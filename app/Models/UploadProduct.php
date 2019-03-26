<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UploadProduct extends Model
{
    use SoftDeletes;

    protected $table = 'upload_product';
}
