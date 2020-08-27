<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\DonorDashboardResource;
use App\Models\Domain;
use App\Models\Donor;
use App\Models\Grant;
use App\Models\Grantee;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard/Index', [
            'donors'  => DonorDashboardResource::collection(
                Donor::with('domains', 'grants.projects')
                    ->get()
            ),
            'stats' => [
                'donors'   => Donor::count(),
                'funding'  => 1 * Grant::sum('amount'),
                'domains'  => Domain::count(),
                'grantees' => Grantee::count(),
            ],
        ]);
    }
}
