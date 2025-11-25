<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->dateTime('event_date');
        $table->decimal('fee', 8, 2)->default(0);
        $table->integer('capacity');
        $table->string('status')->default('open');
        
        // New Relationships (nullable means optional)
        $table->foreignId('category_id')->nullable()->constrained();
        $table->foreignId('venue_id')->nullable()->constrained();
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
