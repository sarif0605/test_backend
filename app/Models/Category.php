<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'image_public_id',
    ];

    public function contents(){
        return $this->hasMany(Content::class);
    }
}
