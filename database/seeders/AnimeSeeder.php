<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Anime;

class AnimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $watching = [
            [
                'title' => 'One Piece',
                'image_url' => 'https://cdn.myanimelist.net/images/anime/6/73245.jpg',
                'score' => 8.7,
                'rank' => 52,
                'popularity' => 20,
                'format' => 'TV Series',
                'episodes' => 1098,
                'status' => 'Watching',
                'season' => 'Fall 1999',
                'genres' => ['Action', 'Adventure', 'Fantasy'],
                'user_rating' => 5,
            ],
            [
                'title' => 'Sword Art Online',
                'image_url' => 'https://cdn.myanimelist.net/images/anime/11/39717.jpg',
                'score' => 7.2,
                'rank' => 3200,
                'popularity' => 5,
                'format' => 'TV Series',
                'episodes' => 25,
                'status' => 'Watching',
                'season' => 'Summer 2012',
                'genres' => ['Action', 'Adventure', 'Fantasy', 'Romance'],
                'user_rating' => 4,
            ],
            [
                'title' => 'Jujutsu Kaisen',
                'image_url' => 'https://cdn.myanimelist.net/images/anime/1171/109222.jpg',
                'score' => 8.6,
                'rank' => 70,
                'popularity' => 15,
                'format' => 'TV Series',
                'episodes' => 24,
                'status' => 'Watching',
                'season' => 'Fall 2020',
                'genres' => ['Action', 'Fantasy'],
                'user_rating' => 5,
            ],
            [
                'title' => 'Cyberpunk: Edgerunners',
                'image_url' => 'https://cdn.myanimelist.net/images/anime/1818/126282.jpg',
                'score' => 8.6,
                'rank' => 90,
                'popularity' => 40,
                'format' => 'ONA',
                'episodes' => 10,
                'status' => 'Watching',
                'season' => 'Fall 2022',
                'genres' => ['Action', 'Sci-Fi'],
                'user_rating' => 5,
            ]
        ];

        $planToWatch = [
            [
                'title' => 'Demon Slayer',
                'image_url' => 'https://cdn.myanimelist.net/images/anime/1286/99889.jpg',
                'score' => 8.5,
                'rank' => 120,
                'popularity' => 10,
                'format' => 'TV Series',
                'episodes' => 26,
                'status' => 'Plan to watch',
                'season' => 'Spring 2019',
                'genres' => ['Action', 'Fantasy'],
                'user_rating' => 0,
            ],
            [
                'title' => 'Fullmetal Alchemist: Brotherhood',
                'image_url' => 'https://cdn.myanimelist.net/images/anime/1223/96541.jpg',
                'score' => 9.1,
                'rank' => 1,
                'popularity' => 3,
                'format' => 'TV Series',
                'episodes' => 64,
                'status' => 'Plan to watch',
                'season' => 'Spring 2009',
                'genres' => ['Action', 'Adventure', 'Drama', 'Fantasy'],
                'user_rating' => 0,
            ],
            [
                'title' => 'Your Lie in April',
                'image_url' => 'https://cdn.myanimelist.net/images/anime/3/67177.jpg',
                'score' => 8.6,
                'rank' => 75,
                'popularity' => 22,
                'format' => 'TV Series',
                'episodes' => 22,
                'status' => 'Plan to watch',
                'season' => 'Fall 2014',
                'genres' => ['Drama', 'Romance'],
                'user_rating' => 0,
            ]
        ];

        $completed = [
            [
                'title' => 'Naruto',
                'image_url' => 'https://cdn.myanimelist.net/images/anime/13/17405.jpg',
                'score' => 8.0,
                'rank' => 600,
                'popularity' => 8,
                'format' => 'TV Series',
                'episodes' => 220,
                'status' => 'Completed',
                'season' => 'Fall 2002',
                'genres' => ['Action', 'Adventure', 'Fantasy'],
                'user_rating' => 4,
            ],
            [
                'title' => 'Death Note',
                'image_url' => 'https://cdn.myanimelist.net/images/anime/9/86483.jpg',
                'score' => 8.6,
                'rank' => 80,
                'popularity' => 1,
                'format' => 'TV Series',
                'episodes' => 37,
                'status' => 'Completed',
                'season' => 'Fall 2006',
                'genres' => ['Supernatural', 'Suspense'],
                'user_rating' => 5,
            ],
            [
                'title' => 'My Hero Academia',
                'image_url' => 'https://cdn.myanimelist.net/images/anime/10/78745.jpg',
                'score' => 7.9,
                'rank' => 800,
                'popularity' => 6,
                'format' => 'TV Series',
                'episodes' => 13,
                'status' => 'Completed',
                'season' => 'Spring 2016',
                'genres' => ['Action'],
                'user_rating' => 4,
            ],
            [
                'title' => 'Assassination Classroom',
                'image_url' => 'https://cdn.myanimelist.net/images/anime/5/70419.jpg',
                'score' => 8.1,
                'rank' => 450,
                'popularity' => 30,
                'format' => 'TV Series',
                'episodes' => 22,
                'status' => 'Completed',
                'season' => 'Winter 2015',
                'genres' => ['Action', 'Comedy'],
                'user_rating' => 5,
            ]
        ];

        foreach (array_merge($watching, $planToWatch, $completed) as $anime) {
            Anime::create($anime);
        }
    }
}
