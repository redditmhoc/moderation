<div>
    <form wire:submit.prevent="upload" class="ui form">
        <div class="field">
            <label for="image">Select image file (.png, .jpg, max 5mb size)</label>
            <input type="file" id="image" wire:model="image" placeholder="Select image file (.png, .jpg, max 5mb size)">
        </div>
        <div class="field">
            <label for="caption">Caption</label>
            <input type="text" wire:model="caption" id="caption" placeholder="Discord #main screenshot of infraction">
        </div>
        <div wire:loading wire:target="image">
            <div class="ui icon message">
                <i class="notched circle loading icon"></i>
                <div class="content">
                    Uploading image ...
                </div>
            </div>
        </div>
        <div class="ui divider"></div>
        @if ($image)
            <div class="ui header">Image preview:</div>
            <img class="ui fluid medium image" src="{{ $image->temporaryUrl() }}">
            <div class="ui divider"></div>
        @endif
        @error('image')
            <div class="ui negative message">
                <i class="close icon"></i>
                <div class="header">
                    Error uploading image
                </div>
                <p>{{ $message }}</p>
            </div>
            <div class="ui divider"></div>
        @enderror
        @if ($image)
            <button class="ui primary button" type="submit">Upload image</button>
        @else
            <button disabled class="ui disabled button">Select image first</button>
        @endif
        @if (session()->has('upload-img-attachment-success'))
            <div class="ui positive icon message">
                <i class="check icon"></i>
                <div class="content">
                    <div class="header">Uploaded!</div>
                    <p>Click the <b>Back</b> button at the top of the page to return.</p>
                </div>
            </div>
        @endif
    </form>
</div>
