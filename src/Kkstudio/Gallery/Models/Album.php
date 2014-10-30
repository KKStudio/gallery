<?php namespace Kkstudio\Gallery\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Http\Traits\Sortable as SortableTrait;

class Album extends Eloquent {

	use SortableTrait;

	protected $table = 'kkstudio_gallery_albums';

	protected $guarded = [ 'id' ];

	public function pictures() {

		return $this->hasMany('Kkstudio\Gallery\Models\Picture', 'album_id', 'id');

	}

	public function getThumb() {

		$path = public_path('assets/gallery/album_thumb_' . $this->image);

		if(is_readable($path)) return asset('assets/gallery/album_thumb_' . $this->image);

		return  asset('assets/gallery/album_thumb_default.png');

	}

	public function getImage() {

		$path = public_path('assets/gallery/album_' . $this->image);

		if(is_readable($path)) return asset('assets/gallery/album_' . $this->image);

		return  asset('assets/gallery/album_default.png');

	}

}