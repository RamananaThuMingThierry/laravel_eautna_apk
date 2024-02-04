<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImages extends Model
{
    use HasFactory;

    public $table = "post_images";

    protected $fillable = [
        "image_path",
        "post_id"
    ];

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function getFullUrlAttribute() {
        return asset('storage/' . $this->path);
    }
}
