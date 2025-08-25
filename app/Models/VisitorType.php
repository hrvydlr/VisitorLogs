<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitorType extends Model
{
    use SoftDeletes;
    
    protected $table    = 'visitor_types';
    protected $fillable = ['type_name', 'created_by', 'updated_by'];
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    } // Fillable attributes
    public function visitors()
{
    return $this->hasMany(Visitor::class);
}
}