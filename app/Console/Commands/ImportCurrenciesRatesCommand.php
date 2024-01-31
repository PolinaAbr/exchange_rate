<?php

namespace App\Console\Commands;

use App\Repositories\CurrencyRepository;
use App\Services\Currency\Service;
use Illuminate\Console\Command;

class ImportCurrenciesRatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get currencies rates from nbrb';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new Service();
        $repository = new CurrencyRepository();
        $result = $service->update($repository);

        if ($result) {
            dump('Записи успешно обновлены');
        } else {
            dump('Ошибка при обновлении записей');
        }
    }
}