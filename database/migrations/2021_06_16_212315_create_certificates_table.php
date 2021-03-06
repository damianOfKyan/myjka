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
            $table->foreignId('contractor_id')->constrained('contractors');
            $table->foreignId('driver_id')->nullable()->constrained('contacts');
            // $table->foreignId('washing_procedure_id')->nullable()->constrained('washing_procedures');
            // $table->foreignId('washing_range_id')->nullable()->constrained('washing_ranges');
            // $table->foreignId('detergent_id')->nullable()->constrained('detergents');
            $table->string('series', 10)->unique()->nullable();
            $table->dateTime('date_of_arrival', $precision = 0)->nullable();
            $table->dateTime('date_of_departure', $precision = 0)->nullable();
            $table->string('tractor', 20)->nullable();
            $table->string('bowser', 20)->nullable();
            $table->string('container', 20)->nullable();
            $table->string('last_product', 100)->nullable();
            // $table->unsignedMediumInteger('washing_range')->nullable();
            // $table->unsignedMediumInteger('washing_procedure')->nullable();
            // $table->unsignedMediumInteger('detergents')->nullable();
            $table->string('chamber')->nullable();
            $table->string('partitions', 255)->nullable();
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
