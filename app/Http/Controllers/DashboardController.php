<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Donor;
use App\Models\Grantee;
use App\Services\ChartBuilder;
use Cknow\Money\Money;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request, ChartBuilder $chartBuilder): Response
    {
        $domains = Domain::query()
            ->withTranslation()
            ->get();

        $donors = Donor::all();

        return Inertia::render('Dashboard/Index', [
            'stats' => [
                'donors'   => $donors->count(),
                'domains'  => $domains->count(),
                'grantees' => Grantee::count(),
                'funding'  => Money::sum(...$donors->map->total_funding)->formatWithoutDecimals(),
            ],
            'chart' => $chartBuilder->dashboard($domains),
        ]);
    }
}
