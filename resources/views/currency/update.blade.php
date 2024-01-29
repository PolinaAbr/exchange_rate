@extends('layouts.main')

@section('content')
    <h3>
        <a href="{{ route('currency.index') }}">К списку</a>
    </h3>

    @if ($result)
        <p>Данные успешно обновлены</p>
    @else
        <p>Ошибка при обновлении данных</p>
    @endif
@endsection