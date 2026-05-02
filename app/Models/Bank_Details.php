<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank_Details extends Model
{
    use HasFactory;

    protected $table = 'bank_details';

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
