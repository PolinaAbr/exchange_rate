<?php

namespace App\Http\Controllers\Currency;

class UpdateController extends BaseController
{
    public function __invoke()
    {
        $result = $this->service->update();

        return view('currency.update', compact('result'));
    }
}