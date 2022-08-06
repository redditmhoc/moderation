<nav class="navbar navbar-expand-md">
    <div class="container py-3">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".navbar-collapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav user-select-none">
                <li class="nav-item">
                    <a href="{{ route('site.index') }}" class="nav-link px-4 border-bottom border-2 {{ Request::is('site') ? 'active border-mhoc' : 'border-light' }}">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link px-4 dropdown-toggle border-bottom border-2 {{ Request::is('site/moderation-actions/*') ? 'active border-mhoc' : 'border-light' }}" role="button" data-bs-toggle="dropdown">
                        Dropdown link
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="" class="dropdown-item">Bans</a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item">Mutes</a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item">Note</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav user-select-none">
                tesr
            </ul>
        </div>
    </div>
</nav>
