<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
    	'image',
    	'hash',
	];

    protected $guarded = ['id'];

	protected $appends = [
		'image_url',
	];

	public function getImageUrlAttribute(): string
	{
		return asset(Storage::url($this->image));
	}

	public function likes()
	{
		return $this->hasMany(Like::class, 'image_id', 'id');
	}
}
