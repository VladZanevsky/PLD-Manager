@extends('layouts.layout')

@section('title') {{ $title ?? null }} @endsection

@section('content')
    <!-- Content Header (Page header) -->
    @include('layouts.page-header')

    <!-- Main content -->
    <section class="content">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $title ?? null }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <a href="{{ route("admin.users.create") }}" class="btn btn-primary mb-3">{{ __('messages.user.create') }}</a>
                <form action="{{ url()->current() }}" method="get" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <select class="form-control select2 @error('role') is-invalid @enderror"
                                        name="role" id="role"
                                        onchange="this.form.submit()" style="width: 100%;">
                                    <option value="">Роль пользователя</option>
                                    @foreach(\App\Models\Role::all() as $item)
                                        <option value="{{ $item->name }}" {{ request('role') == $item->name ? 'selected' : '' }}>
                                            {{ $item->name == 'admin' ? 'Администратор' : 'Пользователь'}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                @if(count($users))
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Эл. почта</th>
                                <th>Имя</th>
                                <th>Роль</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->role->name == 'admin' ? "Администратор" : "Пользователь" }}</td>
                                    <td>
                                        <a href="{{ route("admin.users.edit", ['user' => $user->id]) }}" class="btn btn-info btn-sm float-left">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        @if(auth()->user()->role->name === 'admin')
                                            @if(auth()->id() != $user->id)
                                                <form action="{{ route("admin.users.destroy", ['user' => $user->id]) }}" method="post" class="float-left ml-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Подтвердите удаление')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>{{ __('messages.user.none') }}</p>
                @endif
            </div>
            <!-- /.card-body -->

            <div class="card-footer clearfix">
                {{ $users->appends(request()->query())->links('vendor.pagination.my-pagination') }}
            </div>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->

{{--    @include('admin.layouts.datatable-script')--}}
@endsection
