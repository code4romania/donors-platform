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

        Schema::create('model_has_domains', function (Blueprint $table) {
            $table->foreignId('domain_id')->constrained()->onDelete('cascade');
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();

            $table->primary(['domain_id', 'model_id', 'model_type']);
            $table->index(['model_id', 'model_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_has_domains');
        Schema::dropIfExists('domain_translations');
        Schema::dropIfExists('domains');
    }
}
