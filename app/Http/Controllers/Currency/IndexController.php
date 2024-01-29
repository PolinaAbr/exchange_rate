<?php

namespace App\Http\Controllers\Currency;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $arResult = $this->service->list();

        return view('currency.list', compact('arResult'));
    }
}