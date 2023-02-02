<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $fillable = [
        'machine_id', 'merchant_number', 'customer_number', 'refill_id',
        'vendor_id', 'invoice_no', 'bkash_trx_id', 'total_amount', 'discount',
        'payment_method_id', 'status'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function vendor()
    {
        return $this->hasOne('App\Vendor', 'id', 'vendor_id');
    }
}
