<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="<?=route('admin.home')?>" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>{{ __('messages.main') }}</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?=route('admin.users.index')?>" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>{{ __('messages.user.plural') }}</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?=route('admin.fpga-components.index')?>" class="nav-link">
                <i class="nav-icon fas fa-microchip"></i>
                <p>{{ __('messages.fpga_component.plural') }}</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?=route('admin.manufacturers.index')?>" class="nav-link">
                <i class="nav-icon fas fa-tools"></i>
                <p>{{ __('messages.manufacturer.plural') }}</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?=route('admin.standards.index')?>" class="nav-link">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>{{ __('messages.standard.plural') }}</p>
            </a>
        </li>
{{--        <li class="nav-item">--}}
{{--            <a href="<?=route('admin.photos.index')?>" class="nav-link">--}}
{{--                <i class="nav-icon fas fa-camera"></i>--}}
{{--                <p>{{ __('messages.photo.plural') }}</p>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a href="<?=route('admin.videos.index')?>" class="nav-link">--}}
{{--                <i class="nav-icon fas fa-play-circle"></i>--}}
{{--                <p>{{ __('messages.video.plural') }}</p>--}}
{{--            </a>--}}
{{--        </li>--}}

{{--        <li class="nav-item has-treeview">--}}
{{--            <a href="#" class="nav-link">--}}
{{--                <i class="nav-icon fas fa-newspaper"></i>--}}
{{--                <p>--}}
{{--                    {{ __('messages.article.plural') }}--}}
{{--                    <i class="right fas fa-angle-left"></i>--}}
{{--                </p>--}}
{{--            </a>--}}
{{--            <ul class="nav nav-treeview">--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="{{ route('admin.articles.index') }}" class="nav-link">--}}
{{--                        <i class="far fa-circle nav-icon"></i>--}}
{{--                        <p>{{ __('messages.article.list') }}</p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="{{ route('admin.articles.create') }}" class="nav-link">--}}
{{--                        <i class="far fa-circle nav-icon"></i>--}}
{{--                        <p>{{ __('messages.article.create') }}</p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </li>--}}
    </ul>
</nav>
<!-- /.sidebar-menu -->
