<?php

namespace App\Services\Currency;

use App\Models\Currency;
use App\Repositories\CurrencyRepository;
use Illuminate\Support\Facades\Http;

class Service
{
    private function getCurrencies()
    {
        $result = [];

        $url = config('services.nbrb.currencies_url');
        $response = Http::withOptions(['verify' => false])->get($url);

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data as $currency) {
                $result[$currency['Cur_Abbreviation']] = [
                    'name' => $currency['Cur_Name'],
                    'code' => $currency['Cur_Abbreviation'],
                    'period' => $currency['Cur_Periodicity'] ?: 0,
                ];
            }
        }

        return $result;
    }

    private function getRates($period = 0)
    {
        $result = [];

        $url = config('services.nbrb.rates_url');
        $response = Http::withOptions(['verify' => false])->get($url . '?periodicity=' . $period);

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data as $currency) {
                $result[$currency['Cur_Abbreviation']] = [
                    'rate' => $currency['Cur_OfficialRate'] / $currency ['Cur_Scale'],
                ];
            }
        }

        return $result;
    }

    private function getUpdateData()
    {
        $periods = [];
        $rates = [];
        $data = [];

        $currencies = $this->getCurrencies();
        foreach ($currencies as $key => $currency) {
            $periods[$currency['period']] = $currency['period'];
            unset($currencies[$key]['period']);
        }

        if ($periods) {
            foreach ($periods as $period) {
                $rates = array_merge($rates, $this->getRates($period));
            }

            $data = array_merge_recursive(array_intersect_key($currencies, $rates), $rates);
        }

        return $data;
    }

    public function update(CurrencyRepository $repository)
    {
        $data = $this->getUpdateData();

        $result = $repository->updateOrCreate($data);

        return $result;
    }
}