<?php
namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait Invoice
{
    public static function generateInvoice()
    {
        $prefix = 'INV-';
        $timestamp = time();
        $incremenetalNumber = Cache::increment('invoice_number', 1);
        return $prefix . $timestamp . '-' . str_pad($incremenetalNumber, 5, 0, STR_PAD_LEFT);
    }
}