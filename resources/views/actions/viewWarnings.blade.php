@extends('layouts.master')
@section('title', 'View Warnings - ')
@section('content')
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
<div class="ui grid">
    <div class="ui clearing">
        <h1 class="ui left floated header">View Warnings</h1>
        <a href="{{route('actions.createwarning')}}" class="ui right floated primary button">Create Warning</a>
    </div>
</div>
<br>
<br>
<div class="ui grid">
    <table class="ui celled table">
        <thead>
            <th>Reddit Username</th>
            <th>Timestamp</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach($warnings as $w)
                <tr>
                    <td>{{$w->reddit_username}}</td>
                    <td>{{Carbon\Carbon::create($w->timestamp)->toDayDateTimeString()}}</td>
                    <td><a href="{{route('actions.viewwarning', [$w->reddit_username, $w->id])}}">View Warning</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $(document).ready( function () {
    $('.table').DataTable();
    } );
</script>
@endsection
