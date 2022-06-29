<?php

use Culpa\Database\Schema\Blueprint;
use Culpa\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateClients
 */
class CreateClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->boolean('is_active')->default(false);
            $table->string('name');
            $table->string('zip');
            $table->string('city');
            $table->string('country_iso_3166_1');
            $table->string('website');
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->text('description');
            $table->createdBy();
            $table->updatedBy();
            $table->deletedBy(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clients');
    }
}
