<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model {

    use HasFactory;

    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'name',
        'username',
        'password'
    ];

    public function task()
    {
        return $this->hasMany('App\Models\Task');
    }

}
