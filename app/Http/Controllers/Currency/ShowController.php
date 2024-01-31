<?php

namespace App\Http\Controllers\Currency;

use App\Repositories\CurrencyRepository;

class ShowController extends BaseController
{
    public function __invoke($code, CurrencyRepository $repository)
    {
        $currency = $this->repository->getByCode($code);
        
        if (empty($currency)) {
            abort(404);
        }

        $currenciesList = $this->repository->getList();

        return view('currency.json', compact('currency', 'currenciesList'));
    }
}
