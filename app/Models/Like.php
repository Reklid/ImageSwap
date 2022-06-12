<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';

	protected $fillable = [
		'user_id',
		'image_id',
		'count'
	];

	protected $guarded = ['id'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function image()
	{
		return $this->belongsTo(Image::class);
	}

	public function react(string $reaction)
	{
		if ($reaction === 'Like') {
			$this->increment('count');
		} elseif ($reaction === 'Dislike') {
			if ((int)$this->count === 1) $this->delete();
			else $this->decrement('count');
		}
	}
}
