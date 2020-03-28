<?php

namespace App\Http\Controllers\Moderation;

use App\Http\Controllers\Controller;
use App\Models\Moderation\Complaint;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ComplaintsController extends Controller
{
    public function createComplaint()
    {
        return view('moderation.createComplaint');
    }

    public function createComplaintPost(Request $request)
    {
        if (Complaint::where('user_id', Auth::id())->where('archived', false)->first()) {
            return response()->json(['message' => 'You currently have an active complaint. Complaints are marked as \'archived\' when we\'ve finished handling it.'], 400);
        }

         //Validate request
         $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'content' => 'required|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Please fill all fields.'], 400);
        }

        $complaint = new Complaint([
            'subject' => $request->get('subject'),
            'content' => $request->get('content'),
            'timestamp' => Carbon::now(),
            'user_id' => Auth::id(),
        ]);

        $complaint->save();

        //Discord mod chat notification
        $hook = json_encode([
            "content" => "New Moderation Complaint",
            "username" => "Moderation Bot",
            "avatar_url" => "https://gexiii.lieselta.live/img/mhoc.png",
            "tts" => false,
            "embeds" => [
                [
                    "title" => $complaint->subject,
                    "description" => $complaint->content,
                ]
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

        $ch = curl_init();
        curl_setopt_array( $ch, [
            CURLOPT_URL => config('services.discord.webhooks.discord_mods'),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $hook,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ]
        ]);
        $response = curl_exec($ch);
        if (curl_error($ch)) {
            $error = curl_error($ch);
        }
        curl_close($ch);

        return response()->json(['message' => 'Submitted!'], 200);

    }
}
