<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@section('title') AdminLTE 3 | Blank Page @show</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    {{--    <link rel="stylesheet" href="{{ asset('resources/assets/admin/css/admin.css') }}">--}}
    @vite([
        'resources/assets/admin/plugins/fontawesome-free/css/all.min.css',
        'resources/assets/admin/plugins/select2/css/select2.css',
        'resources/assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.css',
        'resources/assets/admin/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.css',

        'resources/assets/admin/css/adminlte.min.css',

        'public/assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
        'public/assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css',
        'public/assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css',

        'resources/assets/admin/plugins/filepond/filepond.min.css',
        'resources/assets/admin/plugins/filepond/filepond-plugin-image-preview.min.css',
        'resources/assets/admin/plugins/filepond/filepond-plugin-image-edit.min.css',
    ])

    <style>
        .ck-editor__editable_inline {
            min-height: 300px;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            @include('layouts.navbar')

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" target="_blank" class="brand-link">
                <img src="{{ asset('assets/admin/img/AdminLogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{ __('messages.site_name') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                @auth
                    <!-- Sidebar user (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="info">
                            <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                        </div>
                        <div class="info">
                            <a href="<?=route('logout')?>" class="d-block">
                                <i class="fas fa-sign-out-alt"></i>
                                Выход
                            </a>
                        </div>
                    </div>
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="info">
                            <a href="<?=route('admin.change-password')?>" class="d-block">{{ __('messages.user.change-password') }}</a>
                        </div>
                    </div>
                @endauth

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="{{ __('messages.search') }}" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                @include('layouts.sidebar-menu')
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            @include('layouts.message')

            @yield('content')

        </div>
        <!-- /.content-wrapper -->

        @include('layouts.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @vite([
        'resources/assets/admin/plugins/fontawesome-kit/fontawesome.js',
        'resources/assets/admin/js/filepond-init.js',
    ])

    <script src="{{ asset('assets/admin/js/admin.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/filepond/filepond.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/filepond/filepond-plugin-image-preview.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/filepond/filepond-plugin-image-edit.js') }}"></script>

    {{-- Datatables --}}
    <script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    {{--@vite([--}}
    {{--    'resources/assets/admin/plugins/jquery/jquery.min.js',--}}
    {{--    'resources/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js',--}}
    {{--    'resources/assets/admin/plugins/select2/js/select2.full.js',--}}
    {{--    'resources/assets/admin/plugins/bs-custom-file-input/bs-custom-file-input.js',--}}
    {{--    'resources/assets/admin/js/adminlte.min.js',--}}
    {{--    'resources/assets/admin/js/demo.js',--}}
    {{--])--}}

    <script>
        $('.nav-sidebar a').each(function () {
            let location = window.location.protocol + '//' + window.location.host + window.location.pathname;
            let link = this.href;
            if (link === location) {
                $(this).addClass('active');
                $(this).closest('.has-treeview').addClass('menu-open');
            }
        });

        bsCustomFileInput.init();
    </script>
    <script src="{{ asset('assets/admin/ckeditor5/build/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/admin/ckfinder/ckfinder.js') }}"></script>

    @yield('scripts')

</body>
</html>
