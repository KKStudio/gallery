<?php namespace Kkstudio\Gallery;

use Illuminate\Support\ServiceProvider;

class GalleryServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('kkstudio/gallery');

		\Route::get('gallery', '\Kkstudio\Gallery\Controllers\GalleryController@index');
		\Route::get('gallery/{slug}', '\Kkstudio\Gallery\Controllers\GalleryController@show');

		\Route::group(['prefix' => 'admin', 'before' => 'admin'], function() {

			\Route::get('gallery', '\Kkstudio\Gallery\Controllers\GalleryController@admin');

			\Route::get('gallery/create', '\Kkstudio\Gallery\Controllers\GalleryController@create');	
			\Route::post('gallery/create', '\Kkstudio\Gallery\Controllers\GalleryController@postCreate');

			\Route::get('gallery/{slug}/edit', '\Kkstudio\Gallery\Controllers\GalleryController@edit');
			\Route::post('gallery/{slug}/edit', '\Kkstudio\Gallery\Controllers\GalleryController@postEdit');

			\Route::get('gallery/{id}/delete', '\Kkstudio\Gallery\Controllers\GalleryController@delete');
			\Route::post('gallery/{id}/delete', '\Kkstudio\Gallery\Controllers\GalleryController@postDelete');
			
			\Route::post('gallery/swap', '\Kkstudio\Gallery\Controllers\GalleryController@swap');			

			\Route::get('gallery/{slug}/pictures', '\Kkstudio\Gallery\Controllers\GalleryController@pictures');
			\Route::post('gallery/{slug}/pictures', '\Kkstudio\Gallery\Controllers\GalleryController@addPicture');
			\Route::post('gallery/{slug}/pictures/delete', '\Kkstudio\Gallery\Controllers\GalleryController@deletePicture');
			\Route::post('gallery/{slug}/pictures/swap', '\Kkstudio\Gallery\Controllers\GalleryController@swapPictures');

		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
