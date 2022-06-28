<div>
    <div class="ui fluid action icon input">
        <input wire:model.defer="query" type="text" placeholder="Don't include the /u/ tag (e.g. Padanub)">
        <button wire:loading.class="disabled loading" wire:click="search" class="ui mhoc icon button">
            <i class="search icon"></i>
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
                                Permanent ban, enacted {{ $result->start_at->diffForHumans() }}
                            @elseif ($result->overturned)
                                Ban overturned
                            @elseif ($result->is_current)
                                Current ban, enacted {{ $result->start_at->diffForHumans() }}, {{ $result->days_remaining }} days remaining
                            @else
                                Ban expired
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
                                Current mute, enacted {{ $result->start_at->diffForHumans() }}, {{ $result->hours_remaining }} hours remaining
                            @else
                                Mute expired
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
