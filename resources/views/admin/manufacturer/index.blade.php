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
                <a href="{{ route("admin.manufacturers.create") }}" class="btn btn-primary mb-3">{{ __('messages.manufacturer.create') }}</a>

                @if(count($manufacturers))
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Название</th>
                                <th>Страна</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($manufacturers as $manufacturer)
                                <tr>
                                    <td>{{ $manufacturer->id }}</td>
                                    <td>{{ $manufacturer->name }}</td>
                                    <td>{{ $manufacturer->country }}</td>

                                    @if(auth()->user()->role->name === 'admin')
                                        <td>
                                            <a href="{{ route("admin.manufacturers.edit", ['manufacturer' => $manufacturer->id]) }}" class="btn btn-info btn-sm float-left">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>

                                            <form action="{{ route("admin.manufacturers.destroy", ['manufacturer' => $manufacturer->id]) }}" method="post" class="float-left ml-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Подтвердите удаление')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>{{ __('messages.manufacturer.none') }}</p>
                @endif
            </div>
            <!-- /.card-body -->

            <div class="card-footer clearfix">
                {{ $manufacturers->appends(request()->query())->links('vendor.pagination.my-pagination') }}
            </div>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->

    {{--    @include('admin.layouts.datatable-script')--}}
@endsection
