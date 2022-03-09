<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ToDo extends Model {

    use HasFactory, SoftDeletes;

    protected $table      = 'to_dos';
    protected $primaryKey = 'id';
    protected $dates      = ['deleted_at'];
    protected $fillable   = [
        'title',
        'detail',
        'status'
    ];

    public function status()
    {
        if($this->status == 1) {
            $status = '<span class="badge badge-dark">Waiting</span>';
        } else if($this->status == 2) {
            $status = '<span class="badge badge-primary">On Process</span>';
        } else if($this->status == 3) {
            $status = '<span class="badge badge-success">Done</span>';
        } else {
            $status = '<span class="badge badge-danger">Invalid</span>';
        }

        return $status;
    }

}
