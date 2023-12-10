<!DOCTYPE html>

<html lang="en" class="light-style" dir="ltr" data-theme="theme-default" data-assets-path="../../assets/"
    data-template="horizontal-menu-template-no-customizer">

<head>
    <title>DPU Kab. Wajo</title>
    @include('partials.style')
    @stack('style')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Menu -->
                    <aside id="layout-menu"
                        class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
                        <div class="container-xxl d-flex h-100 justify-content-between">
                            <a href="index.html" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <img src="https://puprp.wajokab.go.id/asset/logo/dpuprp_light.png" alt="" width="280">
                                </span>
                                {{-- <span class="app-brand-text demo menu-text fw-bolder">DPU Kab Wajo</span> --}}
                            </a>
                            <div class="menu-horizontal-wrapper">
                                <ul class="menu-inner justify-content-center">
                                    <!-- Dashboards -->
                                    <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
                                        <a href="{{ route('home') }}" class="menu-link">
                                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                                            <div data-i18n="Dashboards">Dashboards</div>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ request()->is('kecamatan*') ? 'active' : '' }}">
                                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                                            <div data-i18n="Kecamatan">Kecamatan</div>
                                        </a>
                                        <ul class="menu-sub">
                                            @foreach ($kecamatans as $kecamatan)
                                                <li class="menu-item {{ request()->is('kecamatan*') ? 'active' : '' }}">
                                                    <a href="{{ route('kecamatan', $kecamatan->id) }}"
                                                        class="menu-link">
                                                        <i class="menu-icon tf-icons bx bx-map-alt"></i>
                                                        <div>{{ $kecamatan->nama }}</div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>

                                    <li class="menu-item {{ request()->is('rumus') ? 'active' : '' }}">
                                        <a href="{{ route('rumus') }}" class="menu-link">
                                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                                            <div>Rumus</div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a href="{{ route('login') }}" class="btn btn-primary my-2 justify-content-end">Login</a>
                        </div>
                    </aside>
                    <!-- / Menu -->

                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                    <!--/ Content -->

                    <!-- Footer -->
                    @include('partials.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!--/ Content wrapper -->
            </div>

            <!--/ Layout container -->
        </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <!--/ Layout wrapper -->

    @include('partials.script')
    @stack('script')
</body>

</html>
