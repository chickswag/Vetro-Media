<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingModel extends Model
{
    use HasFactory;
    protected $fillable = ['comment', 'rating', 'user_id','post_id'];
    protected $table = 'ratings';
    public $timestamps = true;
}
