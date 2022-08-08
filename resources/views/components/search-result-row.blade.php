<div>
    @if (isset($data->permanent) && $data->permanent)
        <i class="large red calendar times middle aligned icon"></i>
    @elseif (isset($data->overturned) && $data->overturned)
        <i class="large red times circle outline middle aligned icon"></i>
    @elseif (isset($data->is_current) && $data->is_current)
        <i class="large blue history middle aligned icon"></i>
    @else
        <i class="large check middle aligned icon"></i>
    @endif
    <div class="content">
        <a href="{{ route('site.moderation-actions.bans.show', $data) }}" class="header">{{ $data->reddit_username }}</a>
        <div class="description">
            @if (isset($data->permanent) && $data->permanent)
                Permanent ban, enacted {{ $data->start_at->diffForHumans() }}, {{ $data->summary }}
            @elseif (isset($data->overturned) && $data->overturned)
                Ban overturned
            @elseif (isset($data->is_current) && $data->is_current)
                Current ban, enacted {{ $data->start_at->diffForHumans() }}, {{ $data->days_remaining }} days remaining, {{ $data->summary }}
            @else
                Ban expired {{ $data->end_at->diffForHumans() }}, {{ $data->summary }}
            @endif
        </div>
    </div>
</div>
