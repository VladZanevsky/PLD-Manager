@extends('layouts.layout')

@section('title') {{ $title ?? null }} @endsection

@section('content')
    <!-- Content Header (Page header) -->
    @include('layouts.page-header')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                @isset($component_count)
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-gradient-red">
                            <div class="inner">
                                <h3>{{ $component_count }}</h3>

                                <p>{{ __('messages.fpga_component.plural') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-microchip"></i>
                            </div>
                            <a href="<?=route('admin.fpga-components.index')?>" class="small-box-footer">{{ __('messages.more') }} <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                @endisset
                @isset($manufacturer_count)
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-gradient-teal">
                            <div class="inner">
                                <h3>{{ $manufacturer_count }}</h3>

                                <p>{{ __('messages.manufacturer.plural') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-tools"></i>
                            </div>
                            <a href="<?=route('admin.manufacturers.index')?>" class="small-box-footer">{{ __('messages.more') }} <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                @endisset
                @isset($standard_count)
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-gradient-fuchsia">
                            <div class="inner">
                                <h3>{{ $standard_count }}</h3>

                                <p>{{ __('messages.standard.plural') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <a href="<?=route('admin.standards.index')?>" class="small-box-footer">{{ __('messages.more') }} <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                @endisset
                @isset($language_count)
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-gradient-secondary">
                            <div class="inner">
                                <h3>{{ $language_count }}</h3>

                                <p>{{ __('messages.language.plural') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-globe"></i>
                            </div>
                            <a href="<?=route('admin.languages.index')?>" class="small-box-footer">{{ __('messages.more') }} <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                @endisset
            </div>
            <!-- Small boxes (Stat box) -->
            <div class="row">

                @if(auth()->check() && auth()->user()->role->name === 'admin')
                    @isset($token_count)
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <h3>{{ $token_count }}</h3>

                                    <p>{{ __('messages.token.plural') }}</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-solid fa-key"></i>
                                </div>
                                <a href="<?=route('admin.tokens.index')?>" class="small-box-footer">{{ __('messages.more') }} <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    @endisset
                @endif
                @isset($user_count)
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-gray">
                            <div class="inner">
                                <h3>{{ $user_count }}</h3>

                                <p>{{ __('messages.user.plural') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-solid fa-user"></i>
                            </div>
                            <a href="<?=route('admin.users.index')?>" class="small-box-footer">{{ __('messages.more') }} <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                @endisset
                @isset($photo_count)
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-gradient-maroon">
                            <div class="inner">
                                <h3>{{ $photo_count }}</h3>

                                <p>{{ __('messages.photo.plural') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-solid fa-camera"></i>
                            </div>
                            <a href="<?=route('admin.photos.index')?>" class="small-box-footer">{{ __('messages.more') }} <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                @endisset
                @isset($video_count)
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-gradient-cyan">
                            <div class="inner">
                                <h3>{{ $video_count }}</h3>

                                <p>{{ __('messages.video.plural') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-solid fa-play-circle"></i>
                            </div>
                            <a href="<?=route('admin.videos.index')?>" class="small-box-footer">{{ __('messages.more') }} <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                @endisset
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection
