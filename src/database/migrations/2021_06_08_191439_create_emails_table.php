<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->string('subject');
            $table->string('content_type');
            $table->string('from_email', 400);
            $table->string('from_name', 255)->nullable();
            $table->tinyInteger('status')
                ->default(0)
                ->comment('0 for queued, 1 for bounced, 2 for delivered');
            $table->json('tos');
            $table->json('ccs')->nullable();
            $table->json('bccs')->nullable();
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
        Schema::dropIfExists('emails');
    }
}
