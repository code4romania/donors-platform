<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChartDataRequest;
use App\Services\ChartBuilder;
use App\Services\Exchange;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ChartDataController extends Controller
{
    public function __invoke(ChartDataRequest $request): JsonResponse
    {
        $filters = collect([
            'years'    => $request->years ?? [now()->subYear()->year],
            'domains'  => $request->domains,
            'currency' => Exchange::currency(),
        ]);

        return response()->json(
            Cache::remember(
                'public-chart-' . hash('sha1', $filters->toJson()),
                60 * 60,
                fn () => ChartBuilder::data($filters['years'], $filters['domains'])
            )
        );
    }
}
