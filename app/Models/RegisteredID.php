<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegisteredID extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'visitor_type',
        'id_number',
        'visitor_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at'
    ];

    protected $table = 'registered_ids';

    // Accessor to get full ID like "OJT-001"
    public function getFullIdAttribute()
    {
        return optional($this->visitorType)->type_name . '-' . str_pad($this->id_number, 3, '0', STR_PAD_LEFT);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // New relationship to VisitorType
    public function visitorType()
    {
        return $this->belongsTo(VisitorType::class, 'visitor_type', 'id');
    }
}
