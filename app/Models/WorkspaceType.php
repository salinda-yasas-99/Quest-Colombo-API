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

     // Define the relationship (one workspace type has many workspaces)
     public function workspaces()
     {
         return $this->hasMany(WorkSpace::class, 'workspace_type_id');
     }
}
