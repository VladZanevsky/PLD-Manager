@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Редактирование схемы</h1>

        <div class="card shadow-sm p-4">
            <form action="{{ route('circuits.update', $circuit) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Название схемы</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $circuit->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Описание</label>
                    <textarea class="form-control" id="description" name="description">{{ old('description', $circuit->description) }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">💾 Сохранить</button>
                <a href="{{ route('circuits.index') }}" class="btn btn-secondary">⬅ Назад</a>
            </form>
        </div>
    </div>
@endsection
