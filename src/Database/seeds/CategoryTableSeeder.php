<?php 
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder {
    

	/**
	 * Run the seed file
	 * @return type
	 */
    public function run()
    {
    	$this->cleanUp();

	  	Category::create([
		    'title' => 'PHP',
		    'children' => [
		        [ 'title' => 'Laravel' ],
		        [ 'title' => 'Wordpress' ],
		        [ 'title' => 'APIs',
		          'children' => [
		          	['title' => 'Facebook'],
		          	['title' => 'Youtube'],
		          	['title' => 'Instagram']
		          ]	
		        ]
		    ]
		]);
    }


    /**
	 * truncates the table before seeding
	 * @return type
	 */
	private function cleanUp()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		DB::table('categories')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}
?>