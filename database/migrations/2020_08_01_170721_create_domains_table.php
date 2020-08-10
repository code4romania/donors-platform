<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('domain_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('domain_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['domain_id', 'locale']);
        });

        Schema::create('domain_donor', function (Blueprint $table) {
            $table->foreignId('donor_id')->constrained()->onDelete('cascade');
            $table->foreignId('domain_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domain_donor');
        Schema::dropIfExists('domain_translations');
        Schema::dropIfExists('domains');
    }
}
