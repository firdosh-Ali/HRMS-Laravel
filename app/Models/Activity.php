<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Activity extends Model
{
    use HasFactory, Notifiable, HasApiTokens;
    use softDeletes;
    protected $fillable = [
        'updateStatus',
        'name',
        'description'
    ];
}
