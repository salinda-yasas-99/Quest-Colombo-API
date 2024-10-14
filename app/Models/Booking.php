<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking'; 

    public $timestamps = false;

    protected $fillable = [
        
        'totalCharges',
        'bookedDate',
        'bookedTime',
        'paymentMethod',
        'paymentStatus',
        'bookedSlot',
        'startTime',
        'endTime',
        'user_id',
        'workspace_id',
        'package_id',
        'stripeChargeId'

    ];

    // Define relationship: A booking belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

     // Define relationship: A booking belongs to a user
     public function workspace()
     {
         return $this->belongsTo(WorkSpace::class, 'workspace_id');
     }

       // Define one-to-one relationship with Package
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
 


}
