<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'number',
        'address',
        'visit_date',
        'time_in',
        'time_out',
        'image_path',
        'visitor_type',
        'id_number',
        'created_by',
        'updated_by',
    ];

    public function visitorType()
    {
        return $this->belongsTo(VisitorType::class, 'visitor_type', 'id');
    }


    // Get the user who created the visitor record
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Get the user who last updated the visitor record
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
