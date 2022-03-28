<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link bg-primary">
        <img src="{{ url($setting->path_image ?? '') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3 bg-light" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ $setting->company_name }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (Storage::disk('public')->exists(auth()->user()->path_image))
                <img src="{{ Storage::disk('public')->url(auth()->user()->path_image) }}" alt="" class="img-circle elevation-2">   
                @else
                <img src="{{ asset('AdminLTE/dist/img/user1-128x128.jpg') }}" alt="" class="img-circle elevation-2">
                @endif
            </div>
            <div class="info">
                <a href="{{ route('profile.show') }}" class="d-block" data-toggle="tooltip" data-placement="top" title="Edit Profil">
                    {{ auth()->user()->name }}
                    <i class="fas fa-pencil-alt ml-2 text-sm text-primary"></i>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @if (auth()->user()->hasRole('admin'))
                <li class="nav-header">MASTER</li>
                <li class="nav-item">
                    <a href="{{ route('category.index') }}" class="nav-link {{ request()->is('admin/category*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cube"></i>
                        <p>
                            Kategori
                        </p>
                    </a>
                </li>
                @else
                <li class="nav-header">MASTER</li>
                @endif
                @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('donatur'))
                <li class="nav-item">
                    <a href="{{ route('campaign.index') }}" class="nav-link {{ request()->is('admin/campaign*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>
                            Projek
                        </p>
                    </a>
                </li>
                <li class="nav-header">REFERENSI</li>
                @if (auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a href="{{ route('donatur.index') }}" class="nav-link {{ request()->is('admin/donatur*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>
                            Donatur
                        </p>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('donation.index') }}" class="nav-link {{ request()->is('admin/donation*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-donate"></i>
                        <p>
                            Daftar Donasi
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cashout.index') }}" class="nav-link {{ request()->is('admin/cashout*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-hand-holding-usd"></i>
                        <p>
                            Daftar Pencairan
                        </p>
                    </a>
                </li>
                @endif

                @if (auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a href="{{ route('contact.index') }}" class="nav-link {{ request()->is('admin/contact*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>
                            Kontak Masuk
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('subscriber.index') }}" class="nav-link {{ request()->is('admin/subscriber*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>
                            Subscriber
                        </p>
                    </a>
                </li>
                <li class="nav-header">REPORT</li>
                <li class="nav-item">
                    <a href="{{ route('report.index') }}" class="nav-link {{ request()->is('admin/report*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-pdf"></i>
                        <p>
                            Laporan
                        </p>
                    </a>
                </li>
                @endif

                @if (auth()->user()->hasRole('admin'))
                <li class="nav-header">SISTEM</li>
                <li class="nav-item">
                    <a href="{{ route('setting.index') }}" class="nav-link {{ request()->is('admin/setting*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Pengaturan
                        </p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>