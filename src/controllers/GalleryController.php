<?php namespace Kkstudio\Gallery\Controllers;

use Illuminate\Routing\Controller;
use Kkstudio\Gallery\Repositories\GalleryRepository;

class GalleryController extends Controller {

	public function admin(GalleryRepository $repo) {

		$albums = $repo->albums();

		return \View::make('gallery::admin')->with('albums', $albums);

	}

	public function create() 
	{
		return \View::make('gallery::create');
	}

	public function postCreate(GalleryRepository $repo) 
	{
		if(! \Request::get('name')) {

			\Flash::error('Please provide a name.');

			return \Redirect::back()->withInput();

		}

		$name = \Request::get('name');
		$slug = \Str::slug($name);
		$description = \Request::get('description');
		$image = '';

		$exists = $repo->album($slug);

		if($exists) {

			\Flash::error('Album with that name already exists.');

			return \Redirect::back()->withInput();

		}

		if(\Input::hasFile('image')) {

			$image_name = \Str::random(32) . \Str::random(32) . '.png';
			$image = \Image::make(\Input::file('image')->getRealPath());

            $image->save(public_path('assets/gallery/album_' . $image_name));

            $callback = function ($constraint) { $constraint->upsize(); };
			$image->widen(320, $callback)->heighten(180, $callback);

            $image->save(public_path('assets/gallery/album_thumb_' . $image_name));

            $image = $image_name;

		}

		$lp = $repo->albumMax() + 1;

		$album = $repo->albumCreate($slug, $name, $description, $image, $lp);

		\Flash::success('Album created successfully.');

		return \Redirect::to('admin/gallery');

	}

	public function edit($slug, GalleryRepository $repo) 
	{
		$album = $repo->album($slug);

		return \View::make('gallery::edit')->with('album', $album);
	}

	public function postEdit($slug, GalleryRepository $repo) 
	{
		$album = $repo->album($slug);

		if(! \Request::get('name')) {

			\Flash::error('Please provide a name.');

			return \Redirect::back()->withInput();

		}

		$name = \Request::get('name');
		$slug = \Str::slug($name);
		$description = \Request::get('description');

		$exists = $repo->album($slug);

		if($exists && $exists->id != $album->id) {

			\Flash::error('Album with that name already exists.');

			return \Redirect::back()->withInput();

		}

		if(\Input::hasFile('image')) {

			$image_name = \Str::random(32) . \Str::random(32) . '.png';
			$image = \Image::make(\Input::file('image')->getRealPath());

            $image->save(public_path('assets/gallery/album_' . $image_name));

            $callback = function ($constraint) { $constraint->upsize(); };
			$image->widen(320, $callback)->heighten(180, $callback);

            $image->save(public_path('assets/gallery/album_thumb_' . $image_name));

            $album->image = $image_name;

		}

		$album->name = $name;
		$album->slug = $slug;
		$album->description = $description;	

		$album->save();	

		\Flash::success('Album edited successfully.');

		return \Redirect::to('admin/gallery/'.$slug.'/edit');

	}

	public function delete($id, GalleryRepository $repo) 
	{
		$item = $repo->albumById($id);

		return \View::make('gallery::delete')->with('album', $item);
	}

	public function postDelete($id, GalleryRepository $repo) 
	{
		$item = $repo->albumById($id);
		$item->delete();

		\Flash::success('Album deleted.');

		return \Redirect::to('admin/gallery');
	}

	public function swap(GalleryRepository $repo) {

		$id1 = \Request::get('id1');
		$id2 = \Request::get('id2');

		$first = $repo->albumById($id1);
		$second = $repo->albumById($id2);

		$first->moveAfter($second);

		\Flash::success('Sorted.');

		return \Redirect::back();

	}

	public function pictures($slug, GalleryRepository $repo)
	{

		$album = $repo->album($slug);

		return \View::make('gallery::pictures')->with('album', $album);
		
	}

	public function addPicture($slug, GalleryRepository $repo)
	{

		$album = $repo->album($slug);

		$files = \Input::file('images');

	    foreach($files as $file) {

	    	$image_name = \Str::random(32) . \Str::random(32) . '.png';
			$image = \Image::make($file->getRealPath());

            $image->save(public_path('assets/gallery/' . $image_name));

            $callback = function ($constraint) { $constraint->upsize(); };
			$image->widen(320, $callback)->heighten(180, $callback);

            $image->save(public_path('assets/gallery/thumb_' . $image_name));

            $lp = $repo->pictureMax($album->id) + 1;
            $repo->addImage($album->id, $image_name, $lp);

	    }

		\Flash::success('Images added.');

		return \Redirect::back();
		
	}

	public function deletePicture($slug, GalleryRepository $repo)
	{

		$id = \Request::get('picture_id');

		$picture = $repo->picture($id);
		$picture->delete();

		\Flash::success('Image removed.');

		return \Redirect::back();
		
	}

	public function swapPictures($slug, GalleryRepository $repo)
	{

		$id1 = \Request::get('id1');
		$id2 = \Request::get('id2');

		$first = $repo->picture($id1);
		$second = $repo->picture($id2);

		$first->moveAfter($second);

		\Flash::success('Sorted.');

		return \Redirect::back();

		
	}

}