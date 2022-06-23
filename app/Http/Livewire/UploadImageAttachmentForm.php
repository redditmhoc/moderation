<?php

namespace App\Http\Livewire;

use App\Models\ImageAttachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadImageAttachmentForm extends Component
{
    use WithFileUploads;

    public $attachableType;
    public $attachableId;
    public $image;
    public $caption;

    public function render()
    {
        return view('livewire.upload-image-attachment-form');
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|mimes:png,jpg|max:5120'
        ]);
    }

    public function upload()
    {
        $url = Storage::url($this->image->store('public/image-attachments'));

        $imageAttachment = new ImageAttachment([
            'id' => Str::uuid(),
            'user_id' => auth()->id(),
            'attachable_id' => $this->attachableId,
            'attachable_type' => 'App\\Models\\' . $this->attachableType,
            'url' => $url,
            'caption' => $this->caption
        ]);

        $imageAttachment->save();

        session()->flash('upload-img-attachment-success');
    }
}
