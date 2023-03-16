<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_number',
        'username',
        'phone',
        'governorate',
        'street',
        'email',
        'order_notes',
        'user_id',
        'total_price'
    ];
    public function products()
    {
        return $this
            ->belongsToMany(Product::class)
            ->withPivot(['size', 'color', 'quantity']);
    }

}