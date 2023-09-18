<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengawas extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengawas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nama', 'telp'];

    /**
     * Get all of the project for the Pengawas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function project(): HasMany
    {
        return $this->hasMany(Projects::class);
    }
}
