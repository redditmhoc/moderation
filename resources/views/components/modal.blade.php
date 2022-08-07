<div x-cloak x-show="{{ $alpineShow }}" class="modal modal-bottom sm:modal-middle z-50">
    <div class="modal-box relative">
        <button @click="{{ $alpineShow }} = false" class="absolute right-2 top-2">✕</button>
        {{ $slot }}
    </div>
</div>
