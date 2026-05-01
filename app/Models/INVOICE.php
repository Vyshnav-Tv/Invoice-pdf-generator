<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class INVOICE extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function items()
    {
        return $this->hasMany(INVOICE_ITEMS::class, 'invoice_id');
    }
}
