<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeDocument extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'document_id', 'file_path'];

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
