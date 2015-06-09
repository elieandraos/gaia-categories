<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\Node;
use Vinkla\Translator\Translatable;
use Vinkla\Translator\Contracts\Translatable as TranslatableContract;

class Category extends Node implements TranslatableContract {

	use Translatable;

	protected $table = 'categories';
	protected $fillable = ['title'];
	protected $translatedAttributes = ['title'];
	protected $translator = 'App\Models\CategoryTranslation';


	/**********************
	 * ELOQUANT RELATIONS *
	 **********************/
	public function news()
	{
		return $this->hasMany('App\Models\News');
	}


	/***************
	 * NESTED SETS *
	 ***************/
	public function renderNode($category, $locale = 'en') 
	{
	  $data = [];
	  $data['category']    = $category;
	  $data['id']    = $category->id;
	  $data['title']  = $category->title;
	  $data['locale'] = $locale;
	 
	  $data['edit_url']   = route('admin.categories.edit', $category->id);
	 
	  echo "<li class='dd-item dd3-item' data-id='{$category->id}'>";
	  echo "<div class='dd-handle'><i class='fa fa-bars'></i></div>";
	  echo "<div class='dd3-content'>".view('admin.categories._list_row')->withData($data)->render()."</div>";
	  
	  if ( $category->hasChildren() ) {
	    echo "<ul class='dd-list'>";
	    	foreach($category->getChildren() as $child) $this->renderNode($child, $locale);
	    echo "</ul>";
	  }
	  echo "</li>";
	}


	/**
	 * Resets all the nodes as roots
	 * @param type $categories 
	 * @return type
	 */	
	public static function updateTreeRoots($categories)
	{
		if(is_array($categories))
		{
			foreach($categories as $cat)
			{
				$node = Category::find($cat['id']);
				$node->parent_id = null;
				$node->save();
			}
		}
	}

	
	/**
	 * Rebuilds the tree: update descendants and their order
	 * @param type $categories 
	 * @return type
	 */
	public static function rebuildTree($categories)
	{
		if(is_array($categories))
		{
			foreach($categories as $cat)
			{
				$node = Category::find($cat['id']);
				//$node->descendants->linknodes();
				
				//loop recursively through the children
				if(isset($cat['children']) && is_array($cat['children']))
				{
					foreach($cat['children'] as $child)
					{
						//append the children to their (old/new)parents
						$descendant = Category::find($child['id']);
						$node->append($descendant);

						//shift the descendants to the bottom to get the right order at the end
						$shift = count($descendant->getSiblings());
						$descendant->down($shift);

						Category::rebuildTree($cat['children']);
					}
				}
			}
		}
	}


	/**
	 * a method to get the children by order
	 * @param type $categories 
	 * @return type
	 */	
	public function getChildren()
	{
		return $this->children()->orderBy('_lft')->get();
	}

}
