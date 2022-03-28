<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory;

    public function category_campaign()
    {
        return $this->belongsToMany(Category::class, 'category_campaign');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'campaign_id', 'id');
    }

    public function cashouts()
    {
        return $this->hasMany(Cashout::class, 'campaign_id', 'id');
    }

    public function cashout_latest()
    {
        return $this->hasOne(Cashout::class, 'campaign_id', 'id')
            ->latestOfMany();
    }

    public function statusColor()
    {
        $color = '';

        switch ($this->status) {
            case 'publish':
                $color = 'success';
                break;
            case 'archived':
                $color = 'dark';
                break;
            case 'pending':
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
