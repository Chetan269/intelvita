<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fiilable = ['user_id','activity_name','activity_date','points'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
