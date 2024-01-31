@extends('layouts.main')

@section('content')
<h3>
    <a href="{{ route('currency.index') }}">К списку</a>
</h3>

<p>
    <form action="{{ route('currency.filter') }}" method="POST">
        @csrf
        <select name="code">
                <option value="">--выберите валюту--</option>

                @foreach ($currenciesList as $item)
                    {{ $option = '' }}
                    @if (isset($currency) && $currency->code == $item->code)
                        {{ $option = 'selected' }}
                    @endif

                    <option {{ $option }} value="{{ $item->code }}">{{ $item->code }}</option>
                @endforeach
        </select>
        <button type="submit">Применить</button>
    </form>
</p>

@if (isset($currency))
    {{ $currency->toJson() }}
@else
    {{ $currenciesList->toJson() }}
@endif

@endsection