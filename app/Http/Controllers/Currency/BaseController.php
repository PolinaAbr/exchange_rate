<?php

namespace App\Http\Controllers\Currency;

use App\Http\Controllers\Controller;
use App\Repositories\CurrencyRepository;

class BaseController extends Controller
{
    public $repository;

    public function __construct(CurrencyRepository $repository)
    {
        $this->repository = $repository;
    }
}