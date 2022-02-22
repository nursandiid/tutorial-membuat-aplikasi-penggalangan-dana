<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donation extends Model
{
    use HasFactory;

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_number', 'order_number');
    }

    public function statusText()
    {
        $text = '';

        switch ($this->status) {
            case 'confirmed':
                $text = 'dikonfirmasi';
                break;
            case 'not confirmed':
                $text = 'belum dikonfirmasi';
                break;
            case 'canceled':
                $text = 'dibatalkan';
                break;
            default:
                break;
        }

        return $text;
    }

    public function statusColor()
    {
        $color = '';

        switch ($this->status) {
            case 'confirmed':
                $color = 'success';
                break;
            case 'not confirmed':
                $color = 'dark';
                break;
            case 'canceled':
                $color = 'danger';
                break;
            default:
                break;
        }

        return $color;
    }

    public function scopeDonatur($query)
    {
        return $query->where('user_id', auth()->id());
    }
}
