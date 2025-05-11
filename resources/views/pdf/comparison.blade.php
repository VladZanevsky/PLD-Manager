<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Сравнение ИСПЛ</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        h5 {
            text-align: center;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 80%;
            height: auto;
            display: block;
            margin: 10px auto;
        }
    </style>
</head>
<body>
<h1>Сравнение ИСПЛ</h1>
<table>
    <thead>
    <tr>
        <th>Параметр</th>
        @foreach($components as $component)
            <th>{{ $component->model }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    <tr><td>Частота (МГц)</td>@foreach($components as $c)<td>{{ $c->frequency }}</td>@endforeach</tr>
    <tr><td>LUT</td>@foreach($components as $c)<td>{{ $c->lut_count }}</td>@endforeach</tr>
    <tr><td>Энергопотребление (Вт)</td>@foreach($components as $c)<td>{{ $c->power }}</td>@endforeach</tr>
    <tr><td>I/O</td>@foreach($components as $c)<td>{{ $c->io_count }}</td>@endforeach</tr>
    <tr><td>Стоимость</td>@foreach($components as $c)<td>{{ $c->cost }}</td>@endforeach</tr>
    <tr><td>Стандарты</td>@foreach($components as $c)<td>{{ $c->standards->pluck('name')->join(', ') }}</td>@endforeach</tr>
    </tbody>
</table>

@if(isset($chartImages['frequency']))
    <h5>Частота (МГц)</h5>
    <img src="{{ $chartImages['frequency'] }}" alt="График Частоты">
@endif
@if(isset($chartImages['lut']))
    <h5>LUT</h5>
    <img src="{{ $chartImages['lut'] }}" alt="График LUT">
@endif
@if(isset($chartImages['power']))
    <h5>Энергопотребление (Вт)</h5>
    <img src="{{ $chartImages['power'] }}" alt="График Энергопотребления">
@endif
@if(isset($chartImages['io']))
    <h5>I/O</h5>
    <img src="{{ $chartImages['io'] }}" alt="График I/O">
@endif
@if(isset($chartImages['cost']))
    <h5>Стоимость</h5>
    <img src="{{ $chartImages['cost'] }}" alt="График Стоимости">
@endif
</body>
</html>
