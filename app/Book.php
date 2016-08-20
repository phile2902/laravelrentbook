<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\User;

class Book extends Model
{
    protected $fillable = [
        'name', 'category_id', 'user_id', 'available', 'info', 'imgLink'
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
