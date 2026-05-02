<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function bankDetails()
    {
        return $this->hasOne(Bank_Details::class,'company_id');
    }

    public function invoices()
    {
        return $this->hasMany(INVOICE::class,'company_id');
    }

}
