@extends('layouts.master')
@section('title', 'Dashboard - ')
@section('content')
<h1 class="ui huge header">Dashboard</h1>
<div class="ui card">
    <div class="content">
      <div class="header">{{Auth::user()->username}}</div>
      <div class="meta">
        @foreach (Auth::user()->roles as $r)
        <i style="color:{{$r->colour}}" class="circle icon"></i> {{ucfirst($r->name)}}
        @endforeach
      </div>
      <div class="description">
        <a href="{{route('auth.logout')}}" class="ui red tertiary button">Sign-out</a>
      </div>
    </div>
  </div>
  <br>
  <div class="ui grid">
      <div class="two-wide-column">
          <h3>Bans</h3>
          @can('create ban')
          <a href="{{route('actions.createban')}}" class="ui primary button">Create Ban</a>
          @endcan
          @can('view actions')
          <a href="{{route('actions.viewallbans')}}" class="ui button">View Bans</a>
          @endcan
          <h3>Warnings</h3>
          @can('create warning')
          <a href="{{route('actions.createwarning')}}" class="ui primary button">Create Warning</a>
          @endcan
          @can('view actions')
          <a href="{{route('actions.viewallwarnings')}}" class="ui button">View Warnings</a>
          @endcan
          <h3>Information</h3>
          <a href="{{route('guidance')}}" class="ui button">Guidance and Templates</a>
          <a href="https://docs.google.com/spreadsheets/d/15W_5TU2r683_RRD7kM4NE_Eau7sywyJ2yB47yrPWU2c/edit#gid=313010852" class="ui button">Spreadsheet</a>
          @role('admin')
          <h3>Admin</h3>
          <a href="{{route('admin.managepermissions')}}" class="ui button">Manage Permissions</a>
          @endrole
      </div>
  </div>
@endsection
