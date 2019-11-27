<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBlockedFieldToConfigVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_variables', function (Blueprint $table) {
            $table->boolean('is_invisible')->default(false)->after('value');
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config_variables', function (Blueprint $table) {
            $table->dropColumn('is_invisible');
        });
    }
}
