<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body'
    ];
    protected $casts = [
        'body' => 'array'
    ];

    protected $appends = [
        'title_upper_case'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'post_user', 'post_id', 'user_id');
    }

    public function getTitleUpperCaseAttribute(): string //Accessor
    {
        return strtoupper($this->title);
    }

    public function setTitleAttribute($value): void //Mutator
    {
        $this->attributes['title'] = strtolower($value);
    }
}
