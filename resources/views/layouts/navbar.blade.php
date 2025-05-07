<!-- Left navbar links -->
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" data-enable-remember="true" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="<?=route('admin.home')?>" class="nav-link">{{ __('messages.main') }}</a>
    </li>
    @if(auth()->check() && auth()->user()->role->name === 'admin')
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?=route('admin.users.index')?>" class="nav-link">{{ __('messages.user.plural') }}</a>
        </li>
    @endif
    <li class="nav-item d-none d-sm-inline-block">
        <a href="<?=route('logout')?>" class="nav-link">{{ __('messages.auth.logout.logout') }}</a>
    </li>
</ul>
