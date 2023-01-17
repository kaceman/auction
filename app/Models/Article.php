<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'body',
        'min_price',
        'status',
        'end_time',
    ];

    public function bids() {
        return $this->hasMany(Bid::class)->reorder('created_at', 'desc');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function highestBidObject()
    {
        return Bid::where('article_id', $this->id)->orderBy('bid_price', 'desc')->first();
    }

    public function highestBid()
    {
        $highestBid = Bid::where('article_id', $this->id)->orderBy('bid_price', 'desc')->first();
        if (!is_null($highestBid)) {
            return $highestBid->bid_price;
        }
        return $this->min_price;
    }
}
