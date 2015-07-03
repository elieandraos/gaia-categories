<?php namespace Gaia\Categories;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


use Gaia\Repositories\CategoryRepositoryInterface;
use Gaia\Repositories\PostTypeRepositoryInterface;
use App\Models\Category;
use App\Models\Locale;
use App\Models\CategoryModules;
use App\Models\News;
use Redirect;
use Auth;
use App;
use Input;
use Flash;
use View;


class CategoryController extends Controller {

	
	public function __construct(CategoryRepositoryInterface $categoryRepositoryInterface, PostTypeRepositoryInterface $postTypeRepositoryInterface)
	{	
		$this->categoryRepos = $categoryRepositoryInterface;
		$this->authUser = Auth::user();

		if(!$this->authUser->can('manage-categories') && !$this->authUser->is('superadmin'))
			App::abort(403, 'Access denied');

		//localization
		$this->locales = Locale::where('language', '!=', 'en')->lists('language', 'language');
		$this->first_locale = array_first($this->locales, function(){return true;});

		//share the post type submenu to the layout
		$this->postTypeRepos = $postTypeRepositoryInterface;
		View::share('postTypesSubmenu', $this->postTypeRepos->renderMenu());
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$sortUrl = route('admin.categories.sort');	
		$categories = $this->categoryRepos->getRoots();
		return view('admin.categories.index')->withCategories($categories)->withSortUrl($sortUrl)->withLocale($this->first_locale);
	}


	/**
	 * Sort the categories
	 * @return type
	 */
	public function sort()
	{
		$input = Input::all();
		$json = $input['json_string'];
		$categories = json_decode($json, true);

		//update tree Roots
		Category::updateTreeRoots($categories);
		//rebuild tree to update descandants and order them
		Category::rebuildTree($categories);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		Category::create($input);
		return Redirect::route('admin.categories.list');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Category $category)
	{
		return view('admin.categories.edit')->withCategory($category);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Category $category)
	{
		$input = Input::all();
		$category->update($input);
		Flash::success('Category was updated successfully.');
		return Redirect::route('admin.categories.list');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Category $category)
	{
		$category->delete();
	}


	/**
	 * Translate the category 
	 * @param type $news 
	 * @return type
	 */
	public function translate(Category $category, $locale)
	{

		App::setLocale($locale);
		
		return view('admin.categories.translate', ["category" => $category, 'locales' => $this->locales, 'locale' => $locale]);
	}


	/**
	 * Save the translated content of the news
	 * @param type $news 
	 * @param type $locale 
	 * @return type
	 */
	public function translateStore(Category $category, $locale)
	{	
		App::setLocale($locale);
		$input = Input::all();
		$category->update($input);
		App::setLocale("en");
		Flash::success('Category was translated successfully.');
		return Redirect::route('admin.categories.list');
	}


	/**
	 * Set the root category for each post type
	 * @return type
	 */
	public function roots()
	{
		$categories = $this->categoryRepos->getRoots()->lists('title', 'id');
		$postTypes = $this->postTypeRepos->getAll();
		
		return view('admin.categories.roots', ["categories" => $categories, 'postTypes' => $postTypes, 'newsCategoryRoot' => News::getConfiguredRootCategory() ]);
	}


	/**
	 * Stores the category/post types configuration
	 * @return type
	 */
	public function storeRoots()
	{
		$input = Input::all();
		
		//save the news first as it is not yet a post type
		if((int)$input['news'])
		{
			$obj = CategoryModules::firstOrNew(['is_news' => 1]);
			$obj->category_id = $input['news'];
			$obj->save();
		}
		//save the post post types root categories
		foreach($input['post_type_id'] as $key => $val)
		{
			$post_type_id = (int)$val;
			$category_id = (int)$input['category_id'][$key];
			if($category_id)
			{
				$obj = CategoryModules::firstOrNew(['post_type_id' => $post_type_id]);
				$obj->category_id = $category_id;
				$obj->save();
			}
		}

		Flash::success('Categories were configured successfully.');
		return Redirect::route('admin.categories.list');
	}


}
