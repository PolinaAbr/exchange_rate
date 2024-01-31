<?php

namespace App\Http\Controllers\Currency;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $currenciesList = $this->repository->getList();

        return view('currency.list', compact('currenciesList'));
    }
}