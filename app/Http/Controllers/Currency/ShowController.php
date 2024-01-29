<?php

namespace App\Http\Controllers\Currency;

class ShowController extends BaseController
{
    public function __invoke($code)
    {
        $arResult = $this->service->json($code);

        return view('currency.json', compact('arResult'));
    }
}
