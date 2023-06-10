<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Biaya extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    protected $guarded = [];
    protected $append = ['nama_biaya_full'];

    /**
     * Interact with the user's first name.
     * 
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function namaBiayaFull(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->nama . ' - ' . $this->formatRupiah('jumlah'),
        );
    }

    /**
     * Get the user that owns the Biaya
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
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
        static::creating(function ($biaya) {
            $biaya->user_id = auth()->user()->id;
        });

        static::updating(function ($biaya) {
            $biaya->user_id = auth()->user()->id;
        });
    }
}
