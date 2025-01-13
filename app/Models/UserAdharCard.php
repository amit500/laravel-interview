<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdharCard extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'aadhar_number', 'masked_aadhar_number'];
}
