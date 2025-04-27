@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center mb-4">Ваши схемы</h1>

        <a href="{{ route('circuits.create') }}" class="btn btn-success mb-3">
            ➕ Добавить схему
        </a>

        @if($circuits->isEmpty())
            <div class="alert alert-warning">Нет доступных схем.</div>
        @else
            <div class="row">
                @foreach($circuits as $circuit)
                    <div class="col-md-4">
                        <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $circuit->name }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($circuit->description, 50) }}</p>
                                <a href="{{ route('circuits.show', $circuit) }}" class="btn btn-primary btn-sm">Подробнее</a>

                                <a href="{{ route('circuits.edit', $circuit) }}" class="btn btn-warning btn-sm">✏️ Редактировать</a>

                                <form action="{{ route('circuits.destroy', $circuit) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить схему?')">🗑️ Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
