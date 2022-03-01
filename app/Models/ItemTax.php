<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemTax extends Model {

    use HasFactory;

    protected $connection = 'mysql';
    protected $table      = 'item_taxes';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'item_id',
        'tax_id'
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }

    public function tax()
    {
        return $this->belongsTo('App\Models\Tax');
    }

}
