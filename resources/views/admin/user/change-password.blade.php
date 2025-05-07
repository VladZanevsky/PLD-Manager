@extends('layouts.layout')

@section('title') {{ $title ?? null }} @endsection

@section('content')
    <!-- Content Header (Page header) -->
    @include('layouts.page-header')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title ?? null }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('admin.change-password.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        @include('layouts.form.password', [
                                            'title' => 'Старый пароль*',
                                            'name' => 'current_password',
                                            'placeholder' => "Старый пароль*",
                                        ])
                                    </div>
                                    <div class="col-4">
                                        @include('layouts.form.password', [
                                            'title' => 'Новый пароль*',
                                            'name' => 'new_password',
                                            'placeholder' => "Новый пароль*",
                                        ])
                                    </div>
                                    <div class="col-4">
                                        @include('layouts.form.password', [
                                            'title' => 'Повторить новый пароль*',
                                            'name' => 'new_password_confirmation',
                                            'placeholder' => "Повторить новый пароль*",
                                        ])
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
