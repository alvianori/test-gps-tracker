<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class BaseModel extends Model
{
    // Contoh: konversi timezone ke Asia/Jakarta saat serialisasi
    protected function serializeDate(\DateTimeInterface $date)
    {
        return Carbon::instance($date)->timezone('Asia/Jakarta')->toDateTimeString();
    }
}
