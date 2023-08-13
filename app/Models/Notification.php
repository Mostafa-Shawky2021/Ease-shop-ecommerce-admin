<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $guarded = [];
    public  $keyType = 'string';

    public function notifiable()
    {
        return $this->morphTo();
    }
}
