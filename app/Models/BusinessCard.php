<?php

namespace App\Models;

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


}
