<?php

namespace App\Http\Livewire;

use App\Models\IssueReport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

class CreateIssueReport extends Component
{
    public $pageUrl;
    public $content;

    public function render()
    {
        return view('livewire.create-issue-report');
    }

    public function save()
    {
        $this->validate([
            'pageUrl' => 'required|url',
            'content' => 'required'
        ]);

        $report = IssueReport::create([
            'id' => Str::uuid(),
            'user_id' => auth()->id(),
            'page_url' => $this->pageUrl,
            'content' => $this->content
        ]);

        Log::notice('New issue report sent', [
            'Sent by' => $report->user->username,
            'URL' => $report->page_url,
            'Message' => $report->content
        ]);

        session()->flash('issue-report-saved');
    }
}
