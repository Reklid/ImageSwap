<?php

namespace Tests\Feature;

use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class ImageControllerTest extends TestCase
{
	use RefreshDatabase;

    public function test_index()
    {
        $response = $this->getJson(route('images.index'));
        $response->assertStatus(401);

        $user = User::query()->first();
        $this->actingAs($user);

		$response = $this->getJson(route('images.index'));
		$response->assertStatus(200);
    }

	public function test_show()
	{
		$image = Image::query()->first();

		$response = $this->getJson(route('images.show', ['image' => $image->hash]));
		$response->assertStatus(401);

		$user = User::query()->first();
		$this->actingAs($user);

		$response = $this->getJson(route('images.show', ['image' => $image->hash]));
		$response->assertStatus(200);
	}

	public function test_upload_show()
	{
		$response = $this->getJson(route('images.upload-show'));
		$response->assertStatus(401);

		$user = User::query()->first();
		$this->actingAs($user);

		$response = $this->getJson(route('images.upload-show'));
		$response->assertStatus(200);
	}

	public function test_store()
	{
		$newImagesCount = 3;

		$images = Image::query()->take($newImagesCount)->get();

		$files = [];
		foreach ($images as $image) {
			$name = Str::random(8) . '.png';
			$path = Storage::disk('public')->path($image->image);
			$file = new UploadedFile($path, $name, 'image/png', null, true);

			array_push($files, $file);
		}

		$response = $this->postJson(route('images.store'), ['images' => $files]);
		$response->assertStatus(401);

		$user = User::query()->first();
		$this->actingAs($user);

		$response = $this->postJson(route('images.store'), ['images' => $files]);
		$response->assertStatus(200);

		$this->assertDatabaseCount('images', 20 + $newImagesCount);
	}

	public function test_react()
	{
		$image = Image::query()->first();

		$response = $this->postJson(route('images.react', ['image' => $image->hash, 'reaction' => 'Like']));
		$response->assertStatus(401);

		$user = User::query()->first();
		$this->actingAs($user);

		$response = $this->postJson(route('images.react', ['image' => $image->hash, 'reaction' => 'Like']));
		$response->assertStatus(200);

		$this->assertDatabaseHas('likes', [
			'user_id' => $user->id,
			'image_id' => $image->id,
			'count' => 1
		]);

		$response = $this->postJson(route('images.react', ['image' => $image->hash, 'reaction' => 'Dislike']));
		$response->assertStatus(200);

		$this->assertDatabaseMissing('likes', [
			'user_id' => $user->id,
			'image_id' => $image->id
		]);
	}
}
