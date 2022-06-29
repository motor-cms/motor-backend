<?php

use Culpa\Database\Schema\Blueprint;
use Culpa\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateConfigVariablesTable
 */
class CreateConfigVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_variables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('package');
            $table->string('group');
            $table->string('name');
            $table->string('value');
            $table->timestamps();

            $table->createdBy();
            $table->updatedBy();
            $table->deletedBy(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_variables');
    }
}
