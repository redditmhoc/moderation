<div class="flex flex-col">
    <div class="text-xl font-bold">Search for usernames</div>
    <div class="form-control my-4">
        <div class="input-group">
            <input wire:model.defer="query" type="text" placeholder="Search (no /u/)…" class="input input-bordered flex-grow" />
            <button wire:loading.class="disabled loading" wire:click="search" class="btn btn-square btn-primary">
                <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </button>
        </div>
    </div>
    @if ($banResults)
        <div class="my-2">
            <div class="font-semibold text-lg">{{ $banResults->count() }} ban{{ $banResults->count() != 1 ? 's' : '' }}</div>
            <div class="ui relaxed divided list">
                @foreach($banResults as $result)
                    <div>
                        <x-search-result-row :data="$result" />
                    </div>
                    <div class="item">

                    </div>
                @endforeach
            </div>
        </div>
    @endif
    @if ($muteResults)
        <div class="my-2">
            <div class="font-semibold text-lg">{{ $muteResults->count() }} mute{{ $muteResults->count() != 1 ? 's' : '' }}</div>
            <div class="ui relaxed divided list">
                @foreach($muteResults as $result)
                    <div class="item">
                        @if ($result->is_current)
                            <i class="large blue history middle aligned icon"></i>
                        @else
                            <i class="large check middle aligned icon"></i>
                        @endif
                        <div class="content">
                            <a href="{{ route('site.moderation-actions.mutes.show', $result) }}" class="header">{{ $result->reddit_username }}</a>
                            <div class="description">
                                @if ($result->is_current)
                                    Current mute, enacted {{ $result->start_at->diffForHumans() }}, {{ $result->hours_remaining }} hours remaining, {{ $result->summary }}
                                @else
                                    Mute expired {{ $result->end_at->diffForHumans() }}, {{ $result->summary }}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    @if ($noteResults)
        <div class="my-2">
            <div class="font-semibold text-lg">{{ $noteResults->count() }} note{{ $noteResults->count() != 1 ? 's' : '' }}</div>
            <div class="ui relaxed divided list">
                @foreach($noteResults as $result)
                    <div class="item">
                        <i class="large sticky note middle aligned icon"></i>
                        <div class="content">
                            <a href="{{ route('site.notes.show', $result) }}" class="header">{{ $result->reddit_username }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
