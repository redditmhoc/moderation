<?php

namespace App\Http\Livewire;

use App\Models\ModerationActions\Ban;
use App\Models\ModerationActions\Mute;
use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class SearchUserHistory extends Component
{
    public $query = "";
    public Collection $banResults;
    public Collection $muteResults;
    public Collection $noteResults;

    public function render()
    {
        return view('livewire.search-user-history');
    }

    public function search()
    {
        $this->banResults = new Collection();
        $this->muteResults = new Collection();
        $this->noteResults = new Collection();
        $this->validate([
            'query' => 'min:4|required'
        ]);
        $this->banResults = Ban::where('reddit_username', 'LIKE', '%'.$this->query.'%')->latest()->get();
        $this->muteResults = Mute::where('reddit_username', 'LIKE', '%'.$this->query.'%')->latest()->get();
        $this->noteResults = Note::where('reddit_username', 'LIKE', '%'.$this->query.'%')->latest()->get();
    }
}
