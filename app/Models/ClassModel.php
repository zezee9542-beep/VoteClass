<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'class_name',
        'academic_year',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'class_id');
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'class_id');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'class_id');
    }
}
