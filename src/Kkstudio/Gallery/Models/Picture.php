<?php namespace Kkstudio\Gallery\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Http\Traits\Sortable as SortableTrait;

class Picture extends Eloquent {

	use SortableTrait;

	protected $table = 'kkstudio_gallery_pictures';

	protected $guarded = [ 'id' ];

	public function album() {

		return $this->belongsTo('Kkstudio\Gallery\Models\Album', 'album_id', 'id');

	}

	public function getThumb() {

		$path = public_path('assets/gallery/thumb_' . $this->image);

		if(is_readable($path)) return asset('assets/gallery/thumb_' . $this->image);

		return  asset('assets/gallery/thumb_default.png');

	}

	public function getImage() {

		$path = public_path('assets/gallery/' . $this->image);

		if(is_readable($path)) return asset('assets/gallery/' . $this->image);

		return  asset('assets/gallery/default.png');

	}

}