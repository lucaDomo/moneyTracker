<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory, HasUuids;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'movements';
}
