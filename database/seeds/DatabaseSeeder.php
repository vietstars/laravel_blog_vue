<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        
		// $users = factory(App\User::class, 3)
		// ->create()
		// ->each(function ($user) {
		//     $user->posts()->save(factory(App\Post::class)->make());
		// });
		// $user->posts()->createMany(
		//     factory(App\Post::class, 3)->make()->toArray()
		// );

		factory(App\User::class, 3)->create();
		factory(App\Category::class, 3)->create();
		factory(App\Post::class, 3)->create();
    }
}
