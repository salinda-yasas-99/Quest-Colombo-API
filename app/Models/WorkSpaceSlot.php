<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSpaceSlot extends Model
{
    use HasFactory;

    protected $table = 'workspace_slot'; 

    public $timestamps = false;

    protected $fillable = [
        'date',
        'slot_1',
        'slot_2',
        'slot_3',
        'workspace_id'

    ];

     // One WorkSpaceSlot belongs to one WorkSpace
     public function workspace()
     {
         return $this->belongsTo(WorkSpace::class, 'workspace_id');
     }
}
