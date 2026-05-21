<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header"></div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item">
                    <a href="{{ route('dashboard.index') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#dashboard"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>
                @if (Auth::user()->role == 'admin')
                    <li class="pc-item pc-caption">
                        <label data-i18n="Widget">Master</label>
                        <i class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#line-chart"></use>
                            </svg>
                        </i>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('user.index') }}" class="pc-link">
                            <span class="pc-micon">
                                <svg class="pc-icon">
                                    <use xlink:href="#user"></use>
                                </svg>
                            </span>
                            <span class="pc-mtext">Kelola User</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('kategori.index') }}" class="pc-link">
                            <span class="pc-micon">
                                <svg class="pc-icon">
                                    <use xlink:href="#database"></use>
                                </svg>
                            </span>
                            <span class="pc-mtext">Kelola Kategori</span>
                        </a>
                    </li>
                @endif

                <li class="pc-item pc-caption">
                    <label data-i18n="Widget">Arsip</label>
                    <i class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#line-chart"></use>
                        </svg>
                    </i>
                </li>
                <li class="pc-item pc-hasmenu {{ request()->is('arsip') ? 'pc-trigger' : '' }}">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#swap"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext" data-i18n="Menu levels">Unit Pengolah</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        @php
                            $users = Auth::user()->role == 'admin' ? \App\Models\User::where('role', 'unit pengolah')->get() : \App\Models\User::where('id', Auth::id())->get();
                        @endphp

                        @foreach ($users as $user)
                            <li class="pc-item {{ $user->id == request()->get('id_user') ? 'active' : '' }}">
                                <a class="pc-link" href="{{ route('arsip.index', ['id_user' => $user->id]) }}">
                                    {{ $user->nama }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <li class="pc-item">
                    <a href="{{ route('laporan.index') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#flag"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Laporan</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label data-i18n="Widget">Akun</label>
                    <i class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#line-chart"></use>
                        </svg>
                    </i>
                </li>

                <li class="pc-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="pc-link border-0 bg-transparent w-100 text-start">
                            <span class="pc-micon">
                                <svg class="pc-icon">
                                    <use xlink:href="#logout"></use>
                                </svg>
                            </span>
                            <span class="pc-mtext">Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
