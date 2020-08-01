<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFocusAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('focus_areas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('focus_area_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('focus_area_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['focus_area_id', 'locale']);
        });

        Schema::create('donor_focus_area', function (Blueprint $table) {
            $table->foreignId('donor_id')->constrained()->onDelete('cascade');
            $table->foreignId('focus_area_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donor_focus_area');
        Schema::dropIfExists('focus_area_translations');
        Schema::dropIfExists('focus_areas');
    }
}
