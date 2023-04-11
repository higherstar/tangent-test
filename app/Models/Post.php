<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  protected $fillable = ['title', 'content', 'user_id', 'category_id'];

  public function category()
  {
    return $this->hasOne(Category::class);
  }

  public function comments()
  {
    return $this->hasMany(Comment::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
