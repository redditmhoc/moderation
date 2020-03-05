@extends('layouts.master')
@section('title', 'Dashboard - ')
@section('content')
<div class="ui container" style="margin-top: 20px;">
    <div class="ui secondary pointing menu">
        <a class="active item">
            Dashboard
        </a>
        <div class="ui dropdown item">
            Speakership
            <i class="dropdown icon"></i>
            <div class="menu">
                <a href="" class="item"><i class="mail icon"></i>Send Modmail</a>
            </div>
        </div>
        <div class="ui dropdown item">
            Moderation
            <i class="dropdown icon"></i>
            <div class="menu">
                <a href="#" class="item"><i class="mail icon"></i>Submit Complaint</a>
                @can('view actions')
                <div class="divider"></div>
                <div class="header">Actions</div>
                <a href="" class="item">Bans</a>
                <a href="" class="item">Warnings</a>
                @endcan
                @can('access')
                <div class="divider"></div>
                <div class="header">Help</div>
                <a href="" class="item">Guidance & Templates</a>
                @endcan
            </div>
        </div>
        @role('admin')
        <div class="ui dropdown item">
            Admin
            <i class="dropdown icon"></i>
            <div class="menu">
                <a href="{{route('auth.logout')}}" class="item">Manage Permissions</a>
            </div>
        </div>
        @endrole
        <div class="right menu">
            <a href="" class="ui item">mhoc.co.uk</a>
            <div href="#" class="ui dropdown item">
                <i class="user icon"></i> <b>{{Auth::user()->username}}</b>
                <div class="menu">
                    <div class="header">
                        @foreach (Auth::user()->roles as $r)
                        <i style="color:{{$r->colour}}" class="circle icon"></i> {{ucfirst($r->name)}}
                        @endforeach                    </div>
                    <a class="item"><i class="user icon"></i> View Your Data</a>
                    <a href="{{route('auth.logout')}}" class="item"><i class="key icon"></i> Sign Out</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(" .ui.dropdown").dropdown();
    </script>
</div>
<div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
<div class="eight column wide">
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
</div>
</div>
@endsection
