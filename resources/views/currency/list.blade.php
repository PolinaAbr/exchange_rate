@extends('layouts.main')

@section('content')
    <h1>Перечень валют</h1>
    <h3>
        <a href="{{ route('currency.update') }}">Обновить данные</a>
    </h3>
    <h3>
        <a href="{{ route('currency.store') }}">Json</a>
    </h3>
    
    <ul>
        @foreach ($arResult as $currency)
            <li>
                {{ $currency->rate }}
                <a href="{{ route('currency.show', $currency->code) }}">[{{ $currency->code }}]</a>
                {{ $currency->name }}
                ({{ $currency->updated_at }})
            </li>
        @endforeach
    </ul>
@endsection