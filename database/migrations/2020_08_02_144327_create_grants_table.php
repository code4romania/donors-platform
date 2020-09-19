<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grants', function (Blueprint $table) {
            $table->id();
            $table->string('currency', 3);
            $table->decimal('amount', 16, 2)->nullable();
            $table->decimal('regranting_amount', 16, 2)->nullable();

            $table->boolean('matching')->nullable();
            $table->unsignedSmallInteger('project_count')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->foreignId('grant_manager_id')->nullable()->constrained()->onDelete('cascade');

            $table->timestamps();
            $table->timestamp('published_at')->nullable();
        });

        Schema::create('grant_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grant_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unique(['grant_id', 'locale']);
        });

        Schema::create('grantees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('model_has_grants', function (Blueprint $table) {
            $table->foreignId('grant_id')->constrained()->onDelete('cascade');
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();

            $table->primary(['grant_id', 'model_id', 'model_type']);
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
        Schema::dropIfExists('model_has_grants');
        Schema::dropIfExists('grantees');
        Schema::dropIfExists('grant_translations');
        Schema::dropIfExists('grants');
    }
}
