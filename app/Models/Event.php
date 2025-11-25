<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // "guarded = []" means we can mass-assign any column (like title, date, etc.)
    // It's the easiest setting for development.
    protected $guarded = [];

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
}