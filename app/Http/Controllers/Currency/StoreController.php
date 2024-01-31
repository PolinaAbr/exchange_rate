<?php

namespace App\Http\Controllers\Currency;

use App\Http\Requests\Currency\StoreRequest;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        if (isset($data['code'])) {
            return redirect()->route('currency.show', $data['code']);

        } else {
            $currenciesList = $this->repository->getList();

            return view('currency.json', compact('currenciesList'));
        }
    }
}