<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\ExchangeRate;
use AshAllenDesign\LaravelExchangeRates\Facades\ExchangeRate as ExchangeRateApi;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class UpdateExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import monthly average exchange rates to the database';

    protected const DEFAULT_START_DATE = '2007-01-01';

    /**
     * @var \Illuminate\Support\Collection
     */
    private $latestExchangeRates;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currencyPairCount = $this->getCurrencyPairs()->count();

        $this->progressBar = $this->output->createProgressBar($currencyPairCount);
        $this->progressBar->setFormat('%current%/%max% [%bar%] %message%');

        $this->progressBar->setMessage('');
        $this->progressBar->start();

        $data = $this->getCurrencyPairs()
            ->map(fn ($currency) => $this->getMonthlyAvg($currency['from'], $currency['to']))
            ->values()
            ->filter();

        $rateCount = $data->pluck('rates')->map->count()->sum();

        $this->progressBar->setMaxSteps($currencyPairCount + $rateCount);

        $data->each(function ($currencyPair) {
            $currencyPair['rates']->each(function ($rate, $date) use ($currencyPair) {
                $this->progressBar->setMessage(
                    "Importing monthly {$currencyPair['from']}/{$currencyPair['to']} averages for {$date}"
                );

                ExchangeRate::create([
                    'currency_from' => $currencyPair['from'],
                    'currency_to'   => $currencyPair['to'],
                    'rate'          => $rate,
                    'date'          => $date,
                ]);

                $this->progressBar->advance();
            });
        });

        $this->progressBar->setMessage(
            $this->progressBar->getMaxSteps() === $currencyPairCount
                ? 'Nothing to import'
                : "Finished importing {$rateCount} exchange rates"
        );
        $this->progressBar->finish();
        $this->info('');

        return 0;
    }

    public function getMonthlyAvg(string $currency_from, string $currency_to): ?array
    {
        $start_at = $this->getExchangeRateStartAt($currency_from, $currency_to);
        $end_at = Carbon::now()->subMonth()->endOfMonth()->startOfDay();

        if ($end_at->lessThanOrEqualTo($start_at)) {
            return null;
        }

        $response = ExchangeRateApi::shouldCache(false)
            ->exchangeRateBetweenDateRange($currency_from, $currency_to, $start_at, $end_at);

        return [
            'from'  => $currency_from,
            'to'    => $currency_to,
            'rates' => collect($response)
                ->mapToGroups(fn ($rate, $date) => [Carbon::parse($date)->endOfMonth()->toDateString() => $rate])
                ->map(fn ($rates) => $rates->avg()),
        ];
    }

    public function getExchangeRateStartAt(string $currency_from, string $currency_to): ?Carbon
    {
        if (! $this->latestExchangeRates) {
            $this->latestExchangeRates = $this->getCurrencyPairs()
                ->mapWithKeys(function ($currency) {
                    $this->progressBar->setMessage(
                        "Looking for the last stored {$currency['from']}/{$currency['to']} rate"
                    );

                    $latest = ExchangeRate::query()
                        ->latest('date')
                        ->where('currency_from', $currency['from'])
                        ->where('currency_to', $currency['to'])
                        ->first();

                    $this->progressBar->advance();

                    return [
                        "{$currency['from']}-{$currency['to']}" => $latest->date ?? null,
                    ];
                });
        }

        if (! $this->latestExchangeRates["{$currency_from}-{$currency_to}"]) {
            return Carbon::parse(self::DEFAULT_START_DATE)->startOfDay();
        }

        return $this->latestExchangeRates["{$currency_from}-{$currency_to}"]
            ->addMonthWithoutOverflow()
            ->startOfMonth();
    }

    public function getCurrencyPairs(): Collection
    {
        $currencies = collect(config('money.currencies.iso'));

        return $currencies->crossJoin($currencies)
            ->mapSpread(fn (string $from, string $to) => ['from' => $from, 'to' => $to])
            ->reject(fn (array $currency) => $currency['from'] === $currency['to']);
    }
}
