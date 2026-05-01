<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class INVOICE_ITEMS extends Model
{
    use HasFactory;
    protected $fillable = [];

    public function invoice()
    {
        return $this->belongsTo(INVOICE::class, 'invoice_id');
    }
}
