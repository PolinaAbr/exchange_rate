<?php

namespace App\Http\Controllers\Currency;

use App\Services\Currency\Service;

class UpdateController extends BaseController
{
    public function __invoke(Service $service)
    {
        $result = $service->update($this->repository);

        return view('currency.update', compact('result'));
    }
}