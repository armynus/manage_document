<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'notification';
    public $fillable = [
        'document_id',
        'user_id',
        'user_post',
        'document_number',
        'status',
    ];
}
