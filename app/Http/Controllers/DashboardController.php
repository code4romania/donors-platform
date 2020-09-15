<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\DonorDashboardResource;
use App\Models\Domain;
use App\Models\Donor;
use App\Models\Grantee;
use Cknow\Money\Money;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Dashboard/Index', [
            'donors'  => DonorDashboardResource::collection(
                Donor::with('domains')->get()
            ),
            'stats' => [
                'donors'   => Donor::count(),
                'domains'  => Domain::count(),
                'grantees' => Grantee::count(),
                'funding'  => Money::sum(...Donor::all()->map->total_funding)->formatWithoutDecimals(),
            ],
        ]);
    }
}
