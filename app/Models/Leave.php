<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model {

    use HasFactory;

    protected $table      = 'leaves';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'employee_id',
        'date_leave',
        'long_leave',
        'description'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }

}
