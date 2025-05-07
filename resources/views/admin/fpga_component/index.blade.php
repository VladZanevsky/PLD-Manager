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
                <a href="{{ route("admin.fpga-components.create") }}" class="btn btn-primary mb-3">{{ __('messages.fpga_component.create') }}</a>

                @if(count($fpga_components))
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Модель</th>
                                <th>Частота (МГц)</th>
                                <th>Логическая емкость (LUT)</th>
                                <th>Энергопотребление (Вт)</th>
                                <th>Кол-во входов выходов</th>
                                <th>Цена</th>
                                <th>Доступность</th>
                                <th>Производитель</th>
                                <th>Стандарты</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($fpga_components as $fpga_component)
                                <tr>
                                    <td>{{ $fpga_component->id }}</td>
                                    <td>{{ $fpga_component->model }}</td>
                                    <td>{{ $fpga_component->frequency }}</td>
                                    <td>{{ $fpga_component->lut_count }}</td>
                                    <td>{{ $fpga_component->power }}</td>
                                    <td>{{ $fpga_component->io_count }}</td>
                                    <td>{{ $fpga_component->cost }}</td>
                                    <td>{{ $fpga_component->availability }}</td>
                                    <td>{{ $fpga_component->manufacturer->name .' ('. $fpga_component->manufacturer->country .')' }}</td>
                                    <td>
                                        @foreach($fpga_component->standards as $standard)
                                            @if($loop->last)
                                                {{ $standard->name }}
                                            @else
                                                {{ $standard->name . ', ' }}
                                            @endif
                                        @endforeach
                                    </td>

                                    @if(auth()->user()->role->name === 'admin')
                                        <td>
                                            <a href="{{ route("admin.fpga-components.edit", ['fpga_component' => $fpga_component->id]) }}" class="btn btn-info btn-sm float-left">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>

                                            <form action="{{ route("admin.fpga-components.destroy", ['fpga_component' => $fpga_component->id]) }}" method="post" class="float-left ml-1">
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
                    <p>{{ __('messages.fpga_component.none') }}</p>
                @endif
            </div>
            <!-- /.card-body -->

            <div class="card-footer clearfix">
                {{ $fpga_components->appends(request()->query())->links('vendor.pagination.my-pagination') }}
            </div>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->

    {{--    @include('admin.layouts.datatable-script')--}}
@endsection
