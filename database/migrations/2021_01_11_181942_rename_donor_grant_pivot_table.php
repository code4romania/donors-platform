<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RenameDonorGrantPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donor_grant', function (Blueprint $table) {
            $table->foreignId('donor_id')->constrained()->onDelete('cascade');
            $table->foreignId('grant_id')->constrained()->onDelete('cascade');
            $table->string('grant_currency', 3);
            $table->decimal('amount', 16, 2);

            $table->primary(['donor_id', 'grant_id']);
        });

        $this->migrateData();

        Schema::drop('model_has_grants');
    }

    private function migrateData(): void
    {
        $data = collect();

        DB::table('grants')
            ->rightJoin('model_has_grants', 'grants.id', '=', 'grant_id')
            ->get()
            ->groupBy('id')
            ->each(function (Collection $grants) use ($data) {
                $grants->each(fn (object $grant, int $index) => $data->push([
                    'donor_id'       => $grant->model_id,
                    'grant_id'       => $grant->grant_id,
                    'grant_currency' => $grant->currency,
                    'amount'         => $index === 0 ? $grant->amount : 0,
                ]));
            });

        DB::table('donor_grant')->insert($data->all());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donor_grant');
    }
}
