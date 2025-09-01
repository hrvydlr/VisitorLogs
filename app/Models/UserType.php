<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserType extends Model
{
    use SoftDeletes;

    protected $table    = 'users_types';
    protected $fillable = ['name', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at', 'deleted_by'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    // UserType.php
    public function users()
    {
        return $this->hasMany(User::class, 'user_type', 'id');
    }
}
