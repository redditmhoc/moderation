<?php

namespace App\Http\Livewire;

use App\Models\ModerationActions\Ban;
use Livewire\Component;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Storage;

class ExportBansToCsv extends Component
{
    public function render()
    {
        return view('livewire.export-bans-to-csv');
    }

    private function banCursor()
    {
        foreach (Ban::cursor() as $ban) {
            yield $ban;
        }
    }

    public function export()
    {
        $fileName = now()->unix() . '.csv';

        (new FastExcel($this->banCursor()))->export('storage/' . $fileName);

        return Storage::disk('public')->download($fileName);
    }
}
