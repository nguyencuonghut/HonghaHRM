<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Degree extends Model
{
    use HasFactory;
    public $table = "degrees";

    protected $fillable = ['name'];
}
