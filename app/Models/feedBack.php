<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class feedBack extends Model
{
    use HasFactory;

    protected $table = 'feedBack'; 

    public $timestamps = false;

    protected $fillable = [
        
        'name',
        'email',
        'subject',
        'message',
        'status'

    ];

    
}
