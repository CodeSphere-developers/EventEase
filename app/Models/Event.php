<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // "guarded = []" means we can mass-assign any column (like title, start_time, end_time, etc.)
    // It's the easiest setting for development.
    protected $guarded = [];
    // Optionally, you can use $fillable instead if you want to be explicit:
    // protected $fillable = ['title', 'event_date', 'category_id', 'venue_id', 'capacity', 'status', 'image', 'announcement'];

    // Relationship 1: An event belongs to a specific Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship 2: An event belongs to a specific Venue
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    // Relationship 3: An event has many students registered for it
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
    // Relationship 4: An event has many feedbacks
    public function feedbacks()
    {
        return $this->hasMany(\App\Models\Feedback::class);
    }
}