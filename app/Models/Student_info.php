<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_info extends Model
{
    use HasFactory;

    protected $fillable = [
        'avatar',
        'student_id',
        'name',
        'course',
        'year_level',
    ];

    public function temperatureRecords()
    {
        return $this->hasMany(Temparature_records::class);
    }
}
