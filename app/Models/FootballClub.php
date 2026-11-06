<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballClub extends Model
{
    use HasFactory;

    protected $table = 'clubs'; // Вказали назву вашої таблиці з міграції

    protected $fillable = [
        'name',
        'city',
        'founded_year',
        'stadium',
        'points',
    ];
}
