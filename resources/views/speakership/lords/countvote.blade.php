@extends('layouts.master')
@section('content')
@include('layouts.navbar')
<div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
<div class="eight column wide">
<a href="{{route('dash')}}">◀ Dashboard</a><br>
<h5>LORDS SPEAKERSHIP</h5>
<h1 class="ui huge header">Count a vote</h1>
@endsection
