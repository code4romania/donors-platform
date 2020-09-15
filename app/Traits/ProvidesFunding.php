<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

trait ProvidesFunding
{
    use Exchangeable;

    public function getTotalFundingAttribute()
    {
        return $this->exchangeAmounts(
            DB::table('grants')
                ->join('donor_grant', 'grants.id', '=', 'donor_grant.grant_id')
                ->where('donor_grant.donor_id', '=', $this->id)
                ->select(
                    DB::raw('SUM(amount) as amount'),
                    DB::raw('DATE_FORMAT(start_date, "%Y-%m") as date'),
                    'currency'
                )
                ->groupBy('date', 'currency')
                ->get('amount', 'date', 'currency'),
            Request::input('currency', config('money.defaultCurrency'))
        );
    }
}
