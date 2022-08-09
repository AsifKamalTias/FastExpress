<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientToken extends Model
{
    use HasFactory;
    protected $table = 'client_tokens';
    public $timestamps = false;
}
