<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModules extends Model {

	protected $table = 'category_modules';
	protected $fillable = ['category_id', 'post_type_id', 'is_news'];

}
