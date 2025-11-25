<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // 1. Create Users
    \App\Models\User::create([
        'name' => 'School Admin',
        'email' => 'admin@school.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
    ]);

    \App\Models\User::create([
        'name' => 'John Student',
        'email' => 'student@school.com',
        'password' => bcrypt('password'),
        'role' => 'student',
    ]);

    // 2. Create Categories
    $academic = \App\Models\Category::create(['name' => 'Academic']);
    $sports   = \App\Models\Category::create(['name' => 'Sports']);
    $arts     = \App\Models\Category::create(['name' => 'Arts']);

    // 3. Create Venues
    $hall = \App\Models\Venue::create(['name' => 'Main Hall', 'capacity' => 500]);
    $gym  = \App\Models\Venue::create(['name' => 'School Gym', 'capacity' => 200]);
    $lab  = \App\Models\Venue::create(['name' => 'Computer Lab', 'capacity' => 30]);

    // 4. Create Events
    \App\Models\Event::create([
        'title' => 'Science Fair 2025',
        'event_date' => '2025-05-20 09:00:00',
        'fee' => 0.00,
        'capacity' => 50,
        'status' => 'open',
        'category_id' => $academic->id,
        'venue_id' => $hall->id,
    ]);

    \App\Models\Event::create([
        'title' => 'Varsity Basketball Game',
        'event_date' => '2025-06-10 16:00:00',
        'fee' => 5.00,
        'capacity' => 200,
        'status' => 'open',
        'category_id' => $sports->id,
        'venue_id' => $gym->id,
    ]);

    \App\Models\Event::create([
        'title' => 'Painting Workshop',
        'event_date' => '2025-04-12 10:00:00',
        'fee' => 15.00,
        'capacity' => 30,
        'status' => 'closed', // Closed event
        'category_id' => $arts->id,
        'venue_id' => $lab->id,
    ]);
}
}
