<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'business_id', 'people_id'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function people()
    {
        return $this->belongsTo(People::class);
    }
}
