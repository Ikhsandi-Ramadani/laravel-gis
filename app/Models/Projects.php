<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Projects extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the pengawas that owns the Projects
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pengawas(): BelongsTo
    {
        return $this->belongsTo(Pengawas::class);
    }
}
