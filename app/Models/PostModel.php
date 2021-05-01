<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['title', 'content', 'created_by','average_rating'];
    protected $table = 'posts';
    public $timestamps = true;

    public function getUserName()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

}
