<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    public function bank_setting()
    {
        return $this->belongsToMany(Bank::class, 'bank_setting', 'setting_id')
            ->withPivot('account', 'name', 'is_main')
            ->withTimestamps();
    }
}
