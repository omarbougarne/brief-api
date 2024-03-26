<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessCard extends Model
{
    use HasFactory;

    protected $table = 'business_cards';

    protected $fillable = [
        'name',
        'company',
        'title',
        'adress',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}


}
