<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryModulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category_modules', function(Blueprint $table)
		{
			$table->increments('id');
			//settings table to set category roots for each post type, (and the news)
			$table->integer('category_id');
			$table->integer('post_type_id');
			$table->boolean('is_news');

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
		Schema::drop('category_modules');
	}

}
