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
            $table->string('currency');
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
            $table->text('description');
            $table->unique(['grant_id', 'locale']);
        });

        Schema::create('grantees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('donor_grant', function (Blueprint $table) {
            $table->foreignId('grant_id')->constrained()->onDelete('cascade');
            $table->foreignId('donor_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donor_grant');
        Schema::dropIfExists('grantees');
        Schema::dropIfExists('grant_translations');
        Schema::dropIfExists('grants');
    }
}
