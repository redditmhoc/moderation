<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageAttachmentRequest;
use App\Models\ImageAttachment;
use Illuminate\Http\Request;

class ImageAttachmentsController extends Controller
{
    public function create(Request $request)
    {
        if (! $request->has('attachable_type') || ! $request->has('attachable_id')) {
            // Throw exception
            abort(400, 'Attachable data invalid');
        }

        $class = 'App\\Models\\' . $request->get('attachable_type');
        $attachable = $class::where('id', $request->get('attachable_id'))->first();

        if (! $attachable) {
            // Throw exception
            abort(404, 'Attachable not found.');
        }

        return view('site.image-attachments.create', [
            'attachable' => $attachable,
            'attachable_type' => $request->get('attachable_type'),
            'attachable_id' => $request->get('attachable_id')
        ]);
    }

    public function destroy(ImageAttachment $imageAttachment)
    {
        $imageAttachment->delete();
        return redirect()->back();
    }
}
