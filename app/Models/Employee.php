<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model {

    use HasFactory;

    protected $table      = 'employees';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'nip',
        'name',
        'address',
        'date_of_birth',
        'date_join'
    ];

    public function nip()
    {
        $query = Employee::selectRaw('RIGHT(nip, 3) as code')
            ->orderByRaw('RIGHT(nip, 3) DESC')
            ->limit(1)
            ->get();

        if($query->count() > 0) {
            $code = (int)$query[0]->code + 1;
        } else {
            $code = '001';
        }

        return 'IP06' . sprintf('%03s', $code);
    }

    public function leave()
    {
        return $this->hasMany('App\Models\Leave');
    }

}
