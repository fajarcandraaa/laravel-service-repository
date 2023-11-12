<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    use HasFactory;

    protected $table        = 'documents';
    protected $primaryKey   = 'id';
    protected $keyType      = 'string';
    protected $casts        = ['id' => 'string'];
    protected $fillable     = ['id', 'title', 'body'];

}
