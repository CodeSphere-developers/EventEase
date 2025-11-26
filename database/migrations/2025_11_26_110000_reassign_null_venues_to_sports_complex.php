<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Find the ID of the Sports Complex (2000)
        $venue = DB::table('venues')->where('name', 'Sports Complex')->where('capacity', 2000)->first();
        if ($venue) {
            DB::table('events')->whereNull('venue_id')->update(['venue_id' => $venue->id]);
        }
    }

    public function down(): void
    {
        // Optionally revert: set venue_id to null for events assigned in this migration
        $venue = DB::table('venues')->where('name', 'Sports Complex')->where('capacity', 2000)->first();
        if ($venue) {
            DB::table('events')->where('venue_id', $venue->id)->update(['venue_id' => null]);
        }
    }
};
