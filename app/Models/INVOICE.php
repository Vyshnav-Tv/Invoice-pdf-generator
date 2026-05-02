<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class INVOICE extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    protected $guarded = [];


    public function items()
    {
        return $this->hasMany(INVOICE_ITEMS::class, 'invoice_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }

        public function company()
        {
            return $this->belongsTo(Company::class, 'company_id');
        }




}
