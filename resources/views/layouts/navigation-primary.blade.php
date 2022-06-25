<div class="ui container" style="margin-top: 20px;">
    <div class="ui secondary pointing menu">
        <a href="{{ route('site.index') }}" class="{{Request::is('site') ? 'active' : ''}} item">
            Start
        </a>
        @canany(['create bans', 'create mutes', 'create mutes'])
            <div class="ui dropdown item">
                Create
                <i class="dropdown icon"></i>
                <div class="menu">
                    <div class="header">Select one</div>
                    @can('create bans')
                        <a href="{{ route('site.moderation-actions.bans.create') }}" class="item">Ban</a>
                    @endcan
                    @can('create mutes')
                        <a href="#" class="item">Mute</a>
                    @endcan
                    @can('create notes')
                        <a href="#" class="item">Note</a>
                    @endcan
                </div>
            </div>
        @endcanany
        @canany(['view moderation actions', 'view notes'])
            <div class="ui dropdown item">
                Records
                <i class="dropdown icon"></i>
                <div class="menu">
                    <div class="header">Moderation Actions</div>
                    @can('view moderation actions')
                        <a href="{{ route('site.moderation-actions.bans.index') }}" class="item">Bans</a>
                        <a href="#" class="{{Request::is('actions/view/warnings') || Request::is('actions/view/warning/*') || Request::is('actions/create/warning') ? 'active' : ''}} item">Mutes</a>
                    @endcan
                    <div class="divider"></div>
                    <div class="header">Other</div>
                    @can('view notes')
                        <a href="#" class="item">Notes</a>
                    @endcan
                </div>
            </div>
        @endcanany
        @role('Admin')
        <div class="ui dropdown item">
            Admin
            <i class="dropdown icon"></i>
            <div class="menu">
                <a href="#" class="item">Manage Permissions</a>
            </div>
        </div>
        @endrole
        <div class="right menu">
            <a href="#" class="ui item">
                <i class="search icon"></i> Search
            </a>
            <div class="divider"></div>
            @auth
                <div href="#" class="ui dropdown item">
                    <i class="user icon"></i> <b>{{Auth::user()->username}} @impersonating() (impersonating) @endImpersonating</b>
                    <div class="menu">
                        <div class="header">
                            <i style="color:{{ auth()->user()->roles()->first()->colour_hex }}" class="circle icon"></i> {{ucfirst(auth()->user()->roles()->first()->name)}}
                        </div>
                        <a id="viewDataModalB" class="item" href="#"><i class="user icon"></i> View Your Data</a>
                        @hasanyrole('Administrator|Quadrumvirate')
                            <a href="/filament" class="item"><i class="shield icon"></i> Administration</a>
                        @endhasanyrole
                        @impersonating
                            <a href="{{ route('impersonate.leave') }}" class="item"><i class="key icon"></i> Leave impersonation</a>
                        @endImpersonating
                        <a href="{{ route('auth.logout') }}" class="item"><i class="key icon"></i> Logout</a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</div>
@section('scripts')
    <script defer>
        $('.ui.dropdown')
            .dropdown()
        ;

        $(document).on("click", "#viewDataModalB", function(){
            $('#viewDataModal')
                .modal('show')
            ;
        });

        $(document).on("click", "#viewUserHistoryB", function(){
            $('#userHistoryModal')
                .modal('show')
            ;
        });
    </script>
@endsection
