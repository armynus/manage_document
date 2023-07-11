<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryDocument extends Model
{
    use HasFactory;
    use HasFactory;
    public $timestamps = true;
    protected $table = 'category_document';
    public $fillable = [
        'category_name',
    ];
}
