<?php

namespace App\Services\Currency;

use App\Models\Currency;
use Illuminate\Support\Facades\Http;

class Service
{
    private function getCurrencies()
    {
        $arResult = [];

        $url = config('services.nbrb.currencies_url');
        $response = Http::withOptions(['verify' => false])->get($url);

        if ($response->successful()) {
            $arData = $response->json();

            foreach ($arData as $currency) {
                $arResult[$currency['Cur_Abbreviation']] = [
                    'name' => $currency['Cur_Name'],
                    'code' => $currency['Cur_Abbreviation'],
                    'period' => $currency['Cur_Periodicity'] ?: 0,
                ];
            }
        }

        return $arResult;
    }

    private function getRates($period = 0)
    {
        $arResult = [];

        $url = config('services.nbrb.rates_url');
        $response = Http::withOptions(['verify' => false])->get($url . '?periodicity=' . $period);

        if ($response->successful()) {
            $arData = $response->json();

            foreach ($arData as $currency) {
                $arResult[$currency['Cur_Abbreviation']] = [
                    'rate' => $currency['Cur_OfficialRate'] / $currency ['Cur_Scale'],
                ];
            }
        }

        return $arResult;
    }

    private function getUpdateData()
    {
        $arPeriods = [];
        $arRates = [];
        $arData = [];

        $arCurrencies = $this->getCurrencies();
        foreach ($arCurrencies as $key => $currency) {
            $arPeriods[$currency['period']] = $currency['period'];
            unset($arCurrencies[$key]['period']);
        }

        if ($arPeriods) {
            foreach ($arPeriods as $period) {
                $arRates = array_merge($arRates, $this->getRates($period));
            }

            $arData = array_merge_recursive(array_intersect_key($arCurrencies, $arRates), $arRates);
        }

        return $arData;
    }

    public function list()
    {
        $arCurrencies = Currency::all();

        return $arCurrencies;
    }

    public function detail($code)
    {
        $arCurrency = Currency::where('code', $code)->firstOrFail();

        return $arCurrency;
    }

    public function update()
    {
        $arUpdate = $this->getUpdateData();

        $result = Currency::upsert(
            $arUpdate,
            ['code'],
            ['name', 'rate']
        );

        return $result;
    }

    public function json($code = '')
    {
        $arResult = [];

        if ($code) {
            $arResult['item'] = $this->detail($code);
        }

        $arResult['list'] = $this->list();
        $arResult['json'] = isset($arResult['item']) ? $arResult['item']->toJson() : $arResult['list']->toJson();

        return $arResult;
    }
}