<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function products()
    {
        return $this
            ->belongsToMany(Product::class)
            ->withPivot([
                'size',
                'color',
                'quantity'
            ])->using(OrderProduct::class);

    }

    public function notification()
    {
        return $this->morphOne(Notification::class, 'notifiable');
    }

}