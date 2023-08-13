<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $guarded = [];
    public  $keyType = 'string';

    public function notification()
    {
        return $this->morphOne(Notification::class, 'notifiable');
    }
}
