<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateEmailTemplates
 */
class CreateEmailTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->index();
            $table->integer('language_id')->unsigned()->nullable()->index();
            $table->string('name');
            $table->string('subject');
            $table->text('body_text');
            $table->text('body_html');
            $table->string('default_sender_name');
            $table->string('default_sender_email');
            $table->string('default_recipient_name');
            $table->string('default_recipient_email');
            $table->string('default_cc_email');
            $table->string('default_bcc_email');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('email_templates');
    }
}
