<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // អនុញ្ញាតឱ្យបញ្ចូលទិន្នន័យទៅក្នុង attribute 'name' តាមរយៈការបង្កើតដុំ (Mass Assignment)
    protected $fillable = ['name'];
}
