<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contractor_id')->constrained('contacts');
            $table->foreignId('driver_id')->constrained('contacts');
            $table->string('series', 10)->nullable();
            $table->dateTime('date_of_arrival', $precision = 0);
            $table->dateTime('date_of_departure', $precision = 0);
            $table->string('tractor', 20)->nullable();
            $table->string('bowser', 20)->nullable();
            $table->string('container', 20)->nullable();
            $table->string('last_product', 100)->nullable();
            $table->unsignedMediumInteger('washing_range')->nullable();
            $table->unsignedMediumInteger('washing_procedure')->nullable();
            $table->unsignedMediumInteger('detergents')->nullable();
            $table->unsignedMediumInteger('chamber')->nullable();
            $table->unsignedMediumInteger('partitions')->nullable();
            $table->string('seals', 200)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certificates');
    }
}
