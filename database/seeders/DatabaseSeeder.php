<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Team;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $team1 = Team::factory()->create(['name' => 'Team 1']);
        $team2 = Team::factory()->create(['name' => 'Team 2']);

        $user->teams()->attach($team1);
        $user->teams()->attach($team2);

        $post1 = Post::factory()
            ->recycle($team1)
            ->create(['title' => 'This post is on Team 1']);

        $post2 = Post::factory()
            ->recycle($team2)
            ->create(['title' => 'This post is on Team 2']);
    }
}
