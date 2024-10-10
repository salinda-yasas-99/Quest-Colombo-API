<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkspaceType extends Model
{
    use HasFactory;

    protected $table = 'workspace_type'; 

    public $timestamps = false;

    protected $fillable = [
        
        'type_name'
    
    ];
}
