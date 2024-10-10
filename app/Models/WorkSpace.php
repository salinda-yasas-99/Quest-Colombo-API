<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSpace extends Model
{
    use HasFactory;

    protected $table = 'workspace'; 

    public $timestamps = false;

    protected $fillable = [
        
        'name',
        'description',
        'location',
        'fee',
        'imageUrl',
        'workspace_type_id'
    
    ];

    public function workspaceType()
    {
        return $this->belongsTo(WorkspaceType::class, 'workspace_type_id');
    }
}
