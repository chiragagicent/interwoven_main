<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if(!Schema::hasTable('events')){
            Schema::create('events', function (Blueprint $table) {
            $table->integer('event_id');
            $table->integer('admin_id');
            $table->string('title', 100);
            $table->string('media_url', 150)->nullable();
            $table->date('date');
            $table->time('start_time');
            $table->text('description')->nullable();
            $table->string('mode');
            $table->string('online_url', 255)->nullable();
            $table->string('offline_address', 255)->nullable();
            $table->double('lat')->nullable();
            $table->double('long')->nullable();
            $table->dateTime('created_datetime');
            $table->dateTime('updated_datetime');
        });
        }
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
