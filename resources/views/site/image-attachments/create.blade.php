@extends('layouts.main')
@section('content')
    @include('layouts.navigation-primary')
    <div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
        <div class="eight column wide">
            <a href="{{ url()->previous() }}">◀ Back</a><br>
            <h1 class="ui header">Create image attachment for {{ $attachable_type }} ({{ $attachable_id }})</h1>
            @if ($errors->any())
                <div class="ui error message">
                    <div class="header">
                        There were some errors with your submission
                    </div>
                    <div class="ui bulleted list">
                        @foreach ($errors->all() as $e)
                            <div class="item">
                                {{$e}}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="ui segment">
                <livewire:upload-image-attachment-form :attachable-id="$attachable_id" :attachable-type="$attachable_type"/>
            </div>
        </div>
    </div>
@endsection
