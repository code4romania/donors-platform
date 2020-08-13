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
            $table->string('name');
            $table->decimal('amount', 16, 2)->nullable();
            $table->string('currency');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->foreignId('domain_id')->nullable()->constrained()->onDelete('cascade');

            $table->timestamps();
            $table->timestamp('published_at')->nullable();
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

        Schema::create('grant_manager', function (Blueprint $table) {
            $table->foreignId('grant_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->foreignId('grant_id')->constrained()->onDelete('cascade');
            $table->foreignId('grantee_id')->constrained()->onDelete('cascade');

            $table->string('title')->nullable();
            $table->decimal('amount', 16, 2)->nullable();
            $table->string('currency');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
        Schema::dropIfExists('grant_manager');
        Schema::dropIfExists('donor_grant');
        Schema::dropIfExists('grantees');
        Schema::dropIfExists('grants');
    }
}
