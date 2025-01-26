<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temperature_records extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'body_temperature',
    ];

    public function studentInfo()
    {
        return $this->belongsTo(Student_info::class, 'student_id');
    }
}
