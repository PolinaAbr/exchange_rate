<?php

namespace App\Http\Controllers\Currency;

use App\Http\Requests\Currency\StoreRequest;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $arData = $request->validated();

        if (isset($arData['code'])) {
            return redirect()->route('currency.show', $arData['code']);

        } else {
            $arResult = $this->service->json();

            return view('currency.json', compact('arResult'));
        }
    }
}