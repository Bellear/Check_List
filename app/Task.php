<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $primaryKey = 'task_id';

    protected $fillable = [
        'title', 'descr'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'executor_id');
    }
}
