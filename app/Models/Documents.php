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
        'stt',
        'user_id',
        'category_id',
        'department_send',
        'document_number',
        'document_time',
        'document_content',
        'receiver',
        'signer',
        'document_file',
    ];
}
