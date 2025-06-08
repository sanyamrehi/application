<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gallary extends Model
{
    use HasFactory;

    protected $table = 'gallary';

    protected $fillable = [
        'image',
        'status'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
