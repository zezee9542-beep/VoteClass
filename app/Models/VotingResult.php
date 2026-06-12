<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VotingResult extends Model
{
    protected $table = 'voting_results';

    protected $fillable = [
        'candidate_id',
        'class_id',
        'total_votes',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
