<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Find IDs of venues to be deleted
        $toDelete = [
            ['name' => 'Computer Lab', 'capacity' => 30],
            ['name' => 'Main Hall', 'capacity' => 500],
            ['name' => 'School Gym', 'capacity' => 200],
            ['name' => 'Sports Complex', 'capacity' => 200],
        ];
        foreach ($toDelete as $venue) {
            $venueRow = DB::table('venues')->where('name', $venue['name'])->where('capacity', $venue['capacity'])->first();
            if ($venueRow) {
                DB::table('events')->where('venue_id', $venueRow->id)->update(['venue_id' => null]);
                DB::table('venues')->where('id', $venueRow->id)->delete();
            }
        }

        // Rename and update capacities
        DB::table('venues')->where('name', 'microsoft lab')->where('capacity', 0)
            ->update(['name' => 'Microsoft Lab', 'capacity' => 100]);
        DB::table('venues')->where('name', 'iLab')->where('capacity', 50)
            ->update(['capacity' => 100]);
    }

    public function down(): void
    {
        // No-op (optional: could restore old values if needed)
    }
};
