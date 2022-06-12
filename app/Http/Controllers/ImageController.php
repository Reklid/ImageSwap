<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Models\Image;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ImageController extends Controller
{
	public function index()
	{
		$images = Image::query()->paginate(1);

		return view('images.list', ['images' => $images]);
	}

	public function show(Image $image)
	{
		$hasLike = $image->likes()
			->where('user_id', '=', Auth::id())
			->exists();

		return view('images.show', ['path' => $image->image_url, 'hasLike' => $hasLike]);
	}

	public function store(ImageRequest $request)
	{
		$images = $request->file('images');

		$paths = [];
		foreach ($images as $image) {
			$path = $image->store('images', 'public');
			$hash = Str::random(5);

			Image::query()->create([
				'image' => $path,
				'hash' => $hash
			]);

			$imageUrl = route('images.show', ['image' => $hash]);
			array_push($paths, $imageUrl);
		}

		return $paths;
	}

	public function uploadView()
	{
		return view('images.form');
	}

	public function react(Image $image, string $reaction)
	{
		$user = Auth::user();

		$like = Like::query()
			->where('user_id', '=', $user->id)
			->where('image_id', '=', $image->id)
			->first();

		if (!$like) {
			Like::query()->create([
				'user_id' => $user->id,
				'image_id' => $image->id
			]);
		} else {
			$like->react($reaction);
		}

		return $image->likes()
			->where('user_id', '=', Auth::id())
			->exists();
	}
}
