<div class="p-4">
    <div class="flex flex-row w-full">
        <input class="flex-grow" wire:model.defer="query" type="text" placeholder="Don't include the /u/ tag (e.g. Padanub)">
        <button wire:loading.class="disabled loading" wire:click="search" class="bg-mhoc text-white hover:bg-mhoc-400 rounded-tr-md rounded-br-md transition px-2 justify-end">
            <span class="material-icons">search</span>
        </button>
    </div>
    @if ($banResults)
        <div class="ui medium header">{{ $banResults->count() }} ban{{ $banResults->count() != 1 ? 's' : '' }}</div>
        <div class="ui relaxed divided list">
            @foreach($banResults as $result)
                <div class="item">
                    @if ($result->permanent)
                        <i class="large red calendar times middle aligned icon"></i>
                    @elseif ($result->overturned)
                        <i class="large red times circle outline middle aligned icon"></i>
                    @elseif ($result->is_current)
                        <i class="large blue history middle aligned icon"></i>
                    @else
                        <i class="large check middle aligned icon"></i>
                    @endif
                    <div class="content">
                        <a href="{{ route('site.moderation-actions.bans.show', $result) }}" class="header">{{ $result->reddit_username }}</a>
                        <div class="description">
                            @if ($result->permanent)
                                Permanent ban, enacted {{ $result->start_at->diffForHumans() }}, {{ $result->summary }}
                            @elseif ($result->overturned)
                                Ban overturned
                            @elseif ($result->is_current)
                                Current ban, enacted {{ $result->start_at->diffForHumans() }}, {{ $result->days_remaining }} days remaining, {{ $result->summary }}
                            @else
                                Ban expired {{ $result->end_at->diffForHumans() }}, {{ $result->summary }}
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    @if ($muteResults)
        <div class="ui medium header">{{ $muteResults->count() }} mute{{ $muteResults->count() != 1 ? 's' : '' }}</div>
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
    @endif
    @if ($noteResults)
        <div class="ui medium header">{{ $noteResults->count() }} note{{ $noteResults->count() != 1 ? 's' : '' }}</div>
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
    @endif
</div>
