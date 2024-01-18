<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class People extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'dni', 'phone', 'address', 'email'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
}
