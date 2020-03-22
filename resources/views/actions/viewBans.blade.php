@extends('layouts.master')
@section('title', 'View Bans - ')
@section('content')
@include('layouts.navbar')
<div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
<div class="eight column wide">
@php
function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}
@endphp
<a href="{{route('dash')}}">◀ Dashboard</a><br>
<br>
<div class="ui clearing">
    <h1 class="ui left floated header">View Bans</h1>
    <a href="{{route('actions.createban')}}" class="ui right floated primary button">Create Ban</a>
    <a href="#" id="importBansB" class="ui right floated button">Import Bans</a>
    <script>
        $(document).on("click", "#importBansB", function(){
            $('#importBansM')
                .modal('show')
            ;
        });
    </script>
</div>
<div class="ui top attached tabular menu">
    <a class="item active" data-tab="first">Active Bans</a>
    <a class="item" data-tab="second">Permanent Bans</a>
    <a class="item" data-tab="third">Past Bans</a>
    <a data-tab="fourth" class="item">Overturned Bans</a>
</div>
<div class="ui bottom attached tab segment active" data-tab="first">
    <table class="ui celled table">
        <thead>
            <th>Reddit Username</th>
            <th>Strike Level</th>
            <th>Banned At</th>
            <th>Banned Until</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach($activeBans as $b)
                <tr>
                    <td>{{$b->reddit_username}}</td>
                    <td>{{ordinal($b->strike_level)}} Strike</td>
                    <td>{{Carbon\Carbon::create($b->start_timestamp)->toDayDateTimeString()}}</td>
                    <td>{{Carbon\Carbon::create($b->end_timestamp)->toDayDateTimeString()}}</td>
                    <td><a href="{{route('actions.viewban', [$b->reddit_username, $b->id])}}">View Ban</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="ui bottom attached tab segment" data-tab="second">
    <table class="ui celled table">
        <thead>
            <th>Reddit Username</th>
            <th>Banned At</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach($permanentBans as $b)
                <tr>
                    <td>{{$b->reddit_username}}</td>
                    <td>{{Carbon\Carbon::create($b->start_timestamp)->toDayDateTimeString()}}</td>
                    <td><a href="{{route('actions.viewban', [$b->reddit_username, $b->id])}}">View Ban</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="ui bottom attached tab segment" data-tab="third">
    <table class="ui celled table">
        <thead>
            <th>Reddit Username</th>
            <th>Strike Level</th>
            <th>Banned From</th>
            <th>Banned To</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach($pastBans as $b)
                <tr>
                    <td>{{$b->reddit_username}}</td>
                    <td>{{ordinal($b->strike_level)}} Strike</td>
                    <td>{{Carbon\Carbon::create($b->start_timestamp)->toDayDateTimeString()}}</td>
                    <td>{{Carbon\Carbon::create($b->end_timestamp)->toDayDateTimeString()}}</td>
                    <td><a href="{{route('actions.viewban', [$b->reddit_username, $b->id])}}">View Ban</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="ui bottom attached tab segment" data-tab="fourth">
    <table class="ui celled table">
        <thead>
            <th>Reddit Username</th>
            <th>Strike Level</th>
            <th>Banned From</th>
            <th>Banned To</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach($overturnedBans as $b)
                <tr>
                    <td>{{$b->reddit_username}}</td>
                    <td>{{ordinal($b->strike_level)}} Strike</td>
                    <td>{{Carbon\Carbon::create($b->start_timestamp)->toDayDateTimeString()}}</td>
                    <td>{{Carbon\Carbon::create($b->end_timestamp)->toDayDateTimeString()}}</td>
                    <td><a href="{{route('actions.viewban', [$b->reddit_username, $b->id])}}">View Ban</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
$('.menu .item')
  .tab()
;
</script>

<script>
    $(document).ready( function () {
    $('.table').DataTable();
    } );
</script>
<div class="ui modal" id="importBansM">
    <div class="header">Import bans</div>
    <div class="content">
        <form action="{{route('actions.importbans')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="ui form">
                <div class="ui input">
                    <input type="file" name="file" id="">
                </div>
                <input type="submit" value="Submit" class="ui primary button">
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
