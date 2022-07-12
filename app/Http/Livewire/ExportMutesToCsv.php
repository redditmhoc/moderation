<?php

namespace App\Http\Livewire;

use App\Models\ModerationActions\Mute;
use Livewire\Component;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Storage;

class ExportMutesToCsv extends Component
{
    public function render()
    {
        return view('livewire.export-mutes-to-csv');
    }

    private function muteCursor()
    {
        foreach (Mute::cursor() as $mute) {
            yield $mute;
        }
    }

    public function export()
    {
        $fileName = now()->unix() . '.csv';

        (new FastExcel($this->muteCursor()))->export('storage/' . $fileName);

        return Storage::disk('public')->download($fileName);
    }
}
