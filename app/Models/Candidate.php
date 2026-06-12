<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'class_id',
        'name',
        'nis',
        'photo',
        'visi',
        'misi',
        'status',
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function votingResult()
    {
        return $this->hasOne(VotingResult::class, 'candidate_id');
    }
}
