<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,700,900|Display+Playfair:200,300,400,700">
    <link rel="stylesheet" href="{{ asset('assets/front/fonts/icomoon/style.css') }}">

    @vite([
        'resources/assets/admin/plugins/select2/css/select2.css',
        'resources/assets/admin/css/adminlte.min.css',
    ])
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">

</head>
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="200">

<!-- <div class="site-wrap"> -->

<div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
            <span class="icon-close2 js-menu-toggle"></span>
        </div>
    </div>
    <div class="site-mobile-menu-body"></div>
</div>

<header class="site-navbar py-3 js-site-navbar site-navbar-target" role="banner" id="site-navbar">

    <div class="container">
        <div class="row align-items-center">

            <div class="col-11 col-xl-2 site-logo">
                <h1 class="mb-0"><a href="{{ route('home') }}" class="text-white h2 mb-0"><img src="{{ asset('assets/front/images/logo4_new.png') }}" style="width: 7rem; height: 2.5rem"></a></h1>
            </div>
            <div class="col-12 col-md-10 d-none d-xl-block">
                <nav class="site-navigation position-relative text-right" role="navigation">

                    <ul class="site-menu js-clone-nav mx-auto d-none d-lg-block">
                        <li><a href="{{ route('home') }}" class="nav-link">Главная</a></li>
                        <li class="has-children">
                            <a href="#" class="nav-link">О нас</a>
                            <ul class="dropdown">
                                <li><a href="#" class="nav-link">How It Works</a></li>
                                <li><a href="#" class="nav-link">Our Team</a></li>
                            </ul>
                        </li>
                        <li><a href="#" class="nav-link">Контакты</a></li>
                        @auth
                            {{-- Пользователь авторизован --}}
                            @if(Auth::user()->role->name === 'admin')
                                <li><a href="{{ route('admin.home') }}" class="nav-link">Админ панель</a></li>
                            @endif
                            <li>
                                <a href="{{ route('logout') }}" class="nav-link">Выход</a>
                            </li>
                        @else
                            {{-- Гость (не авторизован) --}}
                            <li><a href="{{ route('login') }}" class="nav-link">Вход</a></li>
                            <li><a href="{{ route('register') }}" class="nav-link">Регистрация</a></li>
                        @endauth
                    </ul>
                </nav>
            </div>


            <div class="d-inline-block d-xl-none ml-md-0 mr-auto py-3" style="position: relative; top: 3px;"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu h3"></span></a></div>

        </div>

    </div>
    </div>

</header>



<div class="site-blocks-cover overlay" style="background-image: url({{ asset('assets/front/images/bg145.jpg') }});" data-aos="fade" data-stellar-background-ratio="0.5" id="section-home">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">

            <div class="col-md-8" data-aos="fade-up" data-aos-delay="400">


                <h1 class="text-white font-weight-light text-uppercase font-weight-bold" data-aos="fade-up">Автоматизированная система подбора ИСПЛ</h1>
                <p class="mb-5" data-aos="fade-up" data-aos-delay="100"></p>
                <p data-aos="fade-up" data-aos-delay="200"><a href="#select-ispl" class="btn btn-primary py-3 px-5 text-white">Начать</a></p>

            </div>
        </div>
    </div>
</div>

<main>
    @yield('content')
</main>

<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 mr-auto">
                        <h2 class="footer-heading mb-4">О нас</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam iure deserunt ut architecto dolores quo beatae laborum aliquam ipsam rem impedit obcaecati ea consequatur.</p>
                    </div>

                    <div class="col-md-3">
                        <h2 class="footer-heading mb-4">Быстрое меню</h2>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('home') }}">Главная</a></li>
                            <li><a href="#">О нас</a></li>
                            <li><a href="#">Услуги</a></li>
                            <li><a href="#">Контакты</a></li>
                            @auth()
                                <li><a href="{{ route('logout') }}">Выход</a></li>
                            @else
                                <li><a href="{{ route('login') }}">Вход</a></li>
                                <li><a href="{{ route('register') }}">Регистрация</a></li>
                            @endauth

                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h2 class="footer-heading mb-4">Наши соц. сети</h2>
                        <a href="#" class="pl-0 pr-3"><span class="icon-facebook"></span></a>
                        <a href="#" class="pl-3 pr-3"><span class="icon-twitter"></span></a>
                        <a href="#" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
                        <a href="#" class="pl-3 pr-3"><span class="icon-linkedin"></span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-2 mt-5 text-center">
            <div class="col-md-12">
                <div class="border-top pt-5">
                    <p>
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> Все права защищены. <i class="icon-heart" aria-hidden="true"></i>
                    </p>
                </div>
            </div>

        </div>
    </div>
</footer>
<!-- </div> -->
@yield('scripts')
<script src="{{ asset('assets/front/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets/front/js/jquery-migrate-3.0.1.min.js') }}"></script>
<script src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/front/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/front/js/jquery.stellar.min.js') }}"></script>
<script src="{{ asset('assets/front/js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('assets/front/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/front/js/aos.js') }}"></script>
<script src="{{ asset('assets/front/js/main.js') }}"></script>
<script src="{{ asset('assets/admin/js/admin.js') }}"></script>

</body>
</html>
