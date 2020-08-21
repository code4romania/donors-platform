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

        Schema::create('domainables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('domainable_id')->nullable();
            $table->string('domainable_type')->nullable();
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
        Schema::dropIfExists('domainables');
        Schema::dropIfExists('domain_translations');
        Schema::dropIfExists('domains');
    }
}
