<?php

namespace App\Repositories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

class CurrencyRepository
{
    public function getByCode($code)
    {
        return Currency::where('code', $code)->first();
    }

    public function getList()
    {
        return Currency::all();
    }

    public function updateOrCreate($data)
    {
        return Currency::upsert(
            $data,
            ['code'],
            ['name', 'rate']
        );
    }
}