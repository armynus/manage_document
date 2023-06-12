<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'documents';
    public $fillable = [
        'user_id',
        'department_send',
        'document_number',
        'document_time',
        'document_name',
        'receiver',
        'document_file',
    ];
}
