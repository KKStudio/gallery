
<?php namespace Kkstudio\Gallery\Controllers;

use Illuminate\Routing\Controller;
use Kkstudio\Gallery\Repositories\GalleryRepository;

class GalleryController extends Controller {

	protected $repo;

	public function __construct(GalleryRepository $repo)
	{
		if(! m('Gallery')->enabled()) return \App::abort('404');
		$this->repo = $repo;
	}

	public function index()
	{
		$albums = m('Gallery')->albums();

		return v('gallery.index', [ 'albums' => $albums ]);
	}

	public function show($slug)
	{
		$album = m('Gallery')->album($slug);
		$pictures = $album->pictures;

		return v('gallery.show', [ 'album' => $album, 'pictures' => $pictures ]);
	}

	// Admin

	public function admin() {

		$albums = $this->repo->albums();

		return \View::make('gallery::admin')->with('albums', $albums);

	}

	public function create() 
	{
		return \View::make('gallery::create');
	}

	public function postCreate() 
	{
		if(! \Request::get('name')) {

			\Flash::error('Musisz podać nazwę albumu.');

			return \Redirect::back()->withInput();

		}

		$name = \Request::get('name');
		$slug = \Str::slug($name);
		$description = \Request::get('description');
		$image = '';

		$exists = $this->repo->album($slug);

		if($exists) {

			\Flash::error('Album z tą nazwą już istnieje.');

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

		$lp = $this->repo->albumMax() + 1;

		$album = $this->repo->albumCreate($slug, $name, $description, $image, $lp);

		\Flash::success('Pomyślnie stworzono album.');

		return \Redirect::to('admin/gallery');

	}

	public function edit($slug) 
	{
		$album = $this->repo->album($slug);

		return \View::make('gallery::edit')->with('album', $album);
	}

	public function postEdit($slug) 
	{
		$album = $this->repo->album($slug);

		if(! \Request::get('name')) {

			\Flash::error('Musisz podać nazwę.');

			return \Redirect::back()->withInput();

		}

		$name = \Request::get('name');
		$slug = \Str::slug($name);
		$description = \Request::get('description');

		$exists = $this->repo->album($slug);

		if($exists && $exists->id != $album->id) {

			\Flash::error('Album z tą nazwą już istnieje.');

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

		\Flash::success('Pomyślnie edytowano album.');

		return \Redirect::to('admin/gallery/'.$slug.'/edit');

	}

	public function delete($id) 
	{
		$item = $this->repo->albumById($id);

		return \View::make('gallery::delete')->with('album', $item);
	}

	public function postDelete($id) 
	{
		$item = $repo->albumById($id);
		$item->delete();

		\Flash::success('Album usunięty.');

		return \Redirect::to('admin/gallery');
	}

	public function swap() {

		$id1 = \Request::get('id1');
		$id2 = \Request::get('id2');

		$first = $this->repo->albumById($id1);
		$second = $this->repo->albumById($id2);

		$first->moveAfter($second);

		\Flash::success('Posortowano.');

		return \Redirect::back();

	}

	public function pictures($slug)
	{

		$album = $this->repo->album($slug);

		return \View::make('gallery::pictures')->with('album', $album);
		
	}

	public function addPicture($slug)
	{

		$album = $this->repo->album($slug);

		$files = \Input::file('images');

	    foreach($files as $file) {

	    	$image_name = \Str::random(32) . \Str::random(32) . '.png';
			$image = \Image::make($file->getRealPath());

            $image->save(public_path('assets/gallery/' . $image_name));

            $callback = function ($constraint) { $constraint->upsize(); };
			$image->widen(320, $callback)->heighten(180, $callback);

            $image->save(public_path('assets/gallery/thumb_' . $image_name));

            $lp = $this->repo->pictureMax($album->id) + 1;
            $this->repo->addImage($album->id, $image_name, $lp);

	    }

		\Flash::success('Dodano zdjęcia.');

		return \Redirect::back();
		
	}

	public function deletePicture($slug)
	{

		$id = \Request::get('picture_id');

		$picture = $this->repo->picture($id);
		$picture->delete();

		\Flash::success('Zdjęcie usunięte.');

		return \Redirect::back();
		
	}

	public function swapPictures($slug)
	{

		$id1 = \Request::get('id1');
		$id2 = \Request::get('id2');

		$first = $this->repo->picture($id1);
		$second = $this->repo->picture($id2);

		$first->moveAfter($second);

		\Flash::success('Posortowano.');

		return \Redirect::back();

		
	}

}