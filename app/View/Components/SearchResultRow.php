<?php

namespace App\View\Components;

use App\Models\ModerationActions\Ban;
use App\Models\ModerationActions\Mute;
use App\Models\Note;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchResultRow extends Component
{
    public function __construct(public Ban|Mute|Note $data)
    {}

    public function render(): View
    {
        return view('components.search-result-row', ['data' => $this->data]);
    }
}
