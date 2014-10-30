<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KkstudioCreatePicturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kkstudio_gallery_pictures', function($table) {

			$table->increments('id');
			$table->integer('album_id');
			$table->string('image');
			$table->integer('position');
			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('kkstudio_gallery_pictures');
	}

}
