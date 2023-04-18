<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class NewsComment extends Model
{
    use HasApiTokens, Notifiable, HasFactory;
    protected $table = 'news_comment';
    protected $fillable = [
        'id_news',
        'comment',
        'create_by',
    ];
}
