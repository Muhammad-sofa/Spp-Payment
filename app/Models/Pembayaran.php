<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['tanggal_pembayaran'];
    /**
     * Get the tagihan that owns the Pembayaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class);
    }

    /**
     * Get the user that owns the Pembayaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        //creating adalah sebelum dibuat
        static::creating(function ($tagihan) {
            $tagihan->user_id = auth()->user()->id;
        });

        static::updating(function ($tagihan) {
            $tagihan->user_id = auth()->user()->id;
        });
    }

    /**
     * Get the user that owns the Pembayaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wali(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wali_id');
    }
}
