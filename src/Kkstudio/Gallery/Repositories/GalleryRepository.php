<?php namespace Kkstudio\Gallery\Repositories;

use Kkstudio\Gallery\Models\Album as Album;
use Kkstudio\Gallery\Models\Picture as Picture;

class GalleryRepository {

	public function albumById($id) 
	{
		return Album::findOrFail($id);
	}

	public function albums() 
	{

		return Album::orderBy('position')->get();

	}

	public function album($slug) 
	{

		return Album::where('slug', $slug)->with('pictures')->first();

	}

	public function pictures() 
	{

		return Picture::orderBy('position')->where('album_id', 0)->get();

	}

	public function picture($id) 
	{

		return Picture::findOrFail($id);

	}

	public function albumMax() {

		$position = 0;

		$max = Album::orderBy('position', 'desc')->first();
		if($max) $position = $max->position;

		return $position;

	}	

	public function pictureMax($album_id) {

		$position = 0;

		$max = Picute::where('album_id', $album_id)->orderBy('position', 'desc')->first();
		if($max) $position = $max->position;

		return $position;

	}	

	public function albumCreate($slug, $name, $description, $image, $lp) 
	{
		return Album::create([

			'slug' => $slug,
			'name' => $name,
			'description' => $description,
			'image' => $image,
			'position' => $lp,

		]);
	}

	public function addImage($album_id, $image_name, $lp)
	{
		return Picture::create([

			'album_id' => $album_id,
			'image' => $image_name,
			'position' => $lp

		]);
	}

}