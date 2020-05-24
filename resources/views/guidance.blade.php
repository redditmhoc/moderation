@extends('layouts.master')
@section('title', 'Guidance and Templates - ')
@section('content')
@include('layouts.navbar')
<div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
<div class="eight column wide">
<a href="{{URL::previous()}}">◀ Go Back</a><br>
<h1 class="ui header">Guidance and Templates</h1>
<a href="https://docs.google.com/document/d/1-F-6EaKfGgahJIQA6MdPGJO4BgipEybSU0NTfpweoE4/edit" class="ui pink button">Read this basically (pink is a cool colour)</a>
<h4>Templates</h4>
(removed the templates because there are none)
</div>
</div>
@endsection
