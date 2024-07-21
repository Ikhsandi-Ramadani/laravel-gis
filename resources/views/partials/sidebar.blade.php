<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg width="50" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 30 30" xml:space="preserve">
                    <style type="text/css">
                        .st0 {
                            fill: none;
                            stroke: #6C3DB7;
                            stroke-width: 4;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st1 {
                            fill: none;
                            stroke: #1F992A;
                            stroke-width: 4;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st2 {
                            fill: none;
                            stroke: #6A83BA;
                            stroke-width: 4;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st3 {
                            fill: #8A8AFF;
                            stroke: #8A8AFF;
                            stroke-width: 2;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st4 {
                            fill: #6C3DB7;
                            stroke: #6C3DB7;
                            stroke-width: 2;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st5 {
                            fill: #A576FF;
                            stroke: #A576FF;
                            stroke-width: 2;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st6 {
                            fill: #F2BB41;
                            stroke: #F2BB41;
                            stroke-width: 2;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st7 {
                            fill: #E08838;
                            stroke: #E08838;
                            stroke-width: 2;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st8 {
                            fill: #1F992A;
                            stroke: #1F992A;
                            stroke-width: 2;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st9 {
                            fill: #5EC11E;
                            stroke: #5EC11E;
                            stroke-width: 2;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st10 {
                            fill: #E3FAFF;
                            stroke: #E3FAFF;
                            stroke-width: 2;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st11 {
                            fill: #FF5093;
                            stroke: #FF5093;
                            stroke-width: 2;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st12 {
                            fill: #B7257F;
                            stroke: #B7257F;
                            stroke-width: 2;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st13 {
                            fill: #5189E5;
                            stroke: #5189E5;
                            stroke-width: 2;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st14 {
                            fill: #6EBAFF;
                            stroke: #6EBAFF;
                            stroke-width: 2;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st15 {
                            fill: #EDD977;
                            stroke: #EDD977;
                            stroke-width: 2;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st16 {
                            fill: #8C43FF;
                            stroke: #8C43FF;
                            stroke-width: 2;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st17 {
                            fill: #5252BA;
                            stroke: #5252BA;
                            stroke-width: 2;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st18 {
                            fill: none;
                            stroke: #E3FAFF;
                            stroke-width: 4;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st19 {
                            fill: #354C75;
                            stroke: #354C75;
                            stroke-width: 2;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }
                    </style>
                    <path class="st4"
                        d="M24,28H6c-1.1,0-2-0.9-2-2v0c0-3.9,3.1-7,7-7h8c3.9,0,7,3.1,7,7v0C26,27.1,25.1,28,24,28z" />
                    <circle class="st14" cx="15" cy="9" r="6" />
                </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">{{ auth()->user()->role }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Page -->
        <li class="menu-item {{ request()->is('/admin') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('admin/pengawas*') ? 'active' : '' }}">
            <a href="{{ route('pengawas.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div>Pengawas</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('admin/kecamatan*') ? 'active' : '' }}">
            <a href="{{ route('kecamatan.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div>Kecamatan</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('admin/project*') ? 'active' : '' }}">
            <a href="{{ route('project.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div>Project</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('admin/monitoring*') ? 'active' : '' }}">
            <a href="{{ route('monitoring') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div>Monitoring</div>
            </a>
        </li>
    </ul>
</aside>
