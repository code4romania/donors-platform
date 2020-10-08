<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Donor;
use App\Models\Grant;
use App\Models\Grantee;
use App\Services\ChartBuilder;
use App\Services\Exchange;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                'donors'   => Donor::count(),
                'domains'  => Domain::count(),
                'grantees' => Grantee::count(),
                'funding'  => Exchange::sumForCurrency(Grant::all())
                    ->formatWithoutDecimals(),
            ],
            'years'   => $this->getSortedYears(),
            'domains' => $this->getSortedDomains(),
            'donors'  => $this->getSortedDonors(),
            'chart'   => ChartBuilder::dashboard(),
        ]);
    }
}
