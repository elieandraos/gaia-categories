<?php namespace Gaia\Categories;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


use Gaia\Repositories\CategoryRepositoryInterface;
use App\Models\Category;
use App\Models\Locale;
use Redirect;
use Auth;
use App;
use Input;


class CategoryController extends Controller {

	
	public function __construct(CategoryRepositoryInterface $categoryRepositoryInterface)
	{
		$this->categoryRepos = $categoryRepositoryInterface;
		$this->authUser = Auth::user();

		//localization
		$this->locales = Locale::where('language', '!=', 'en')->lists('language', 'language');
		$this->first_locale = array_first($this->locales, function(){return true;});
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
		if(!$this->authUser->can('translate-category') && !$this->authUser->is('superadmin'))
			App::abort(403, 'Access denied');

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
		if(!$this->authUser->can('translate-news') && !$this->authUser->is('superadmin'))
			App::abort(403, 'Access denied');
		
		App::setLocale($locale);
		$input = Input::all();
		$category->update($input);
		App::setLocale("en");
		
		return Redirect::route('admin.categories.list');
	}


}
