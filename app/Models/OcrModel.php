<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OcrModel extends Model
{
    use HasFactory;
    protected $table = 'ocr';

    protected $fillable = [
        'kode',
        'x',
        'y',
        'width',
        'height',
        'location'
    ];
}
