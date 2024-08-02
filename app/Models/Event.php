<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
     protected $table = 'events'; // Specify the table if different from the model name
    protected $primaryKey = 'event_id'; // Specify the primary key
    public $incrementing = true; // Set to falsze if it's not an auto-incrementing key
    
}
