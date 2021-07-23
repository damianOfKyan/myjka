<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 25)->nullable();
            $table->string('last_name', 25)->nullable();
            $table->string('email', 50)->unique()->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('country', 255)->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
