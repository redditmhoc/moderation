<div x-data="{ searchModal: false }">
    <div class="lg:mx-auto lg:max-w 6xl px-14 py-4">
        <div class="hidden md:flex flex-row justify-between items-center items-stretch">
            <div class="flex flex-row items-center items-stretch">
                <div class="relative inline-block text-center appearance-none">
                    <a href="{{ route('site.index') }}" class="navbar-btn {{Request::is('site') ? 'active' : ''}}">
                        Start
                    </a>
                </div>
                @canany(['create bans', 'create mutes', 'create mutes'])
                    <div x-data="{ open: false }" class="relative inline-block text-center appearance-none">
                        <button x-on:click="open = !open" class="navbar-btn">
                            <div class="flex flex-row items-center">
                                <span>Create</span>
                                <span class="material-icons">arrow_drop_down</span>
                            </div>
                        </button>
                        <div x-cloak x-show="open" @click.outside="open = false" role="menu" class="navbar-dropdown">
                            <div class="navbar-dropdown-heading">Select one</div>
                            @can('create bans')
                                <a href="{{ route('site.moderation-actions.bans.create') }}" class="navbar-dropdown-item">Ban</a>
                            @endcan
                            @can('create mutes')
                                <a href="{{ route('site.moderation-actions.mutes.create') }}" class="navbar-dropdown-item">Mute</a>
                            @endcan
                            @can('create notes')
                                <a href="{{ route('site.notes.create') }}" class="navbar-dropdown-item">Note</a>
                            @endcan
                        </div>
                    </div>
                @endcanany
                @canany(['view moderation actions', 'view notes'])
                    <div x-data="{ open: false }" class="relative inline-block text-center appearance-none">
                        <button x-on:click="open = !open" class="navbar-btn">
                            <div class="flex flex-row items-center">
                                <span>Records</span>
                                <span class="material-icons">arrow_drop_down</span>
                            </div>
                        </button>
                        <div x-cloak x-show="open" @click.outside="open = false" role="menu" class="navbar-dropdown">
                            <div class="navbar-dropdown-heading">Moderation Actions</div>
                            @can('view moderation actions')
                                <a href="{{ route('site.moderation-actions.bans.index') }}" class="navbar-dropdown-item">Bans</a>
                                <a href="{{ route('site.moderation-actions.mutes.index') }}" class="navbar-dropdown-item">Mutes</a>
                            @endcan
                            <div class="navbar-dropdown-heading">Other</div>
                            @can('view notes')
                                <a href="{{ route('site.notes.index') }}" class="navbar-dropdown-item">Notes</a>
                            @endcan
                        </div>
                    </div>
                @endcanany
            </div>
            <div class="border-b-2 border-gray-300 flex-grow"></div>
            <div class="flex flex-row items-center">
                <div class="relative inline-block text-center appearance-none">
                    <button x-on:click="searchModal = !searchModal" class="navbar-btn">
                        <div class="flex flex-row items-center">
                            <span class="material-icons">search</span>
                            <span>Search users</span>
                        </div>
                    </button>
                </div>
                @auth
                    <div x-data="{ open: false }" class="relative inline-block text-center appearance-none">
                        <button x-on:click="open = !open" class="navbar-btn">
                            <div class="flex flex-row space-x-3 items-center">
                                <span class="material-icons">account_circle</span>
                                <span>{{ Auth::user()->username }} @impersonating() (impersonating) @endImpersonating</span>
                            </div>
                        </button>
                        <div x-cloak x-show="open" @click.outside="open = false" role="menu" class="navbar-dropdown">
                            <div class="navbar-dropdown-heading">
                                <div class="flex flex-row space-x-3 items-center">
                                    <div style="background-color:{{ auth()->user()->roles()->first()->colour_hex }}" class="circle icon"></div>
                                    <span>{{ ucfirst(auth()->user()->roles()->first()->name) }}</span>
                                </div>
                            </div>
                            @hasanyrole('Administrator|Quadrumvirate')
                                <a href="/filament" class="navbar-dropdown-item">
                                    <div class="flex flex-row space-x-3 items-center">
                                        <span class="material-icons">admin_panel_settings</span>
                                        <span>Admin Panel</span>
                                    </div>
                                </a>
                            @endhasanyrole
                            @impersonating
                                <a href="{{ route('impersonate.leave') }}" class="navbar-dropdown-item">
                                    <div class="flex flex-row space-x-3 items-center">
                                        <span class="material-icons">logout</span>
                                        <span>Leave impersonation</span>
                                    </div>
                                </a>
                            @endImpersonating
                            <a href="{{ route('auth.logout') }}" class="navbar-dropdown-item hover:bg-red-600">
                                <div class="flex flex-row space-x-3 items-center">
                                    <span class="material-icons">logout</span>
                                    <span>Logout</span>
                                </div>
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
    <x-modal alpine-show="searchModal">
        <livewire:search-user-history/>
    </x-modal>
</div>
