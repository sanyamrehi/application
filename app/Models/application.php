<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class application extends Model
{
    use HasFactory;

    protected $table = 'application';

    protected $fillable = [
        'name',
        'description',
        'gallery_id',
        'status'
    ];

    protected $casts = [
        'gallary_id' => 'array'
    ];

    // Application.php
    public function galleryImages()
    {
        return $this->belongsToMany(Gallary::class, 'application_gallery');
    }
}
