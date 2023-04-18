<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class News extends Model
{
    use HasApiTokens, Notifiable, HasFactory;
    protected $table = 'news';
    protected $fillable = [
        'title',
        'content',
        'image',
        'create_by',
        'edited_by',
    ];
}
