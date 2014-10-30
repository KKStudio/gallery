<?php namespace Kkstudio\Gallery;

class Gallery extends \App\Module {

	protected $repo;

	public function __construct() 
	{
		$this->repo = new Repositories\GalleryRepository;
	}

	public function albums() {

		return $this->repo->albums();

	}

	public function album($slug) {

		return $this->repo->album($slug);

	}

	public function pictures() {

		return $this->repo->pictures();

	}

	public function picture($id) {

		return $this->repo->picture($id);

	}
	
}