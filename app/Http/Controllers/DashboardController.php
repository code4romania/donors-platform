<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\Grant;
use App\Models\Grantee;
use App\Services\ChartBuilder;
use App\Services\Exchange;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $grants = Grant::query()
            ->with('primaryDomain')
            ->published()
            ->get();

        return Inertia::render('Dashboard', [
            'stats' => [
                'donors'   => Donor::published()->count(),
                'domains'  => $this->getPrimaryDomainsCount($grants),
                'grantees' => Grantee::whereHas('projects')->count(),
                'funding'  => Exchange::sumForCurrency($grants)
                    ->formatWithoutDecimals(),
            ],
            'years'   => $this->getSortedYears(),
            'domains' => $this->getSortedDomains(),
            'donors'  => $this->getSortedDonors(),
            'chart'   => ChartBuilder::dashboard(),
        ]);
    }

    private function getPrimaryDomainsCount(Collection $grants): int
    {
        return $grants->pluck('primaryDomain')
            ->flatten()
            ->unique('id')
            ->count();
    }
}
