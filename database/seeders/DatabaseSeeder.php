<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Poem;
use App\Models\Source;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        
        // Create languages
        Language::create([
            'code' => 'sk',
            'name' => 'Slovenčina',
            'is_default' => true,
        ]);
        
        Language::create([
            'code' => 'en',
            'name' => 'English',
            'is_default' => false,
        ]);
        
        // Create author
        Author::create([
            'name' => 'Janko Hráško',
            'bio' => [
                ['lang' => 'sk', 'content' => '<p>Slovenský básnik a spisovateľ. Venoval sa hlavne modernej poézii a experimentálnej literatúre. Jeho diela sú známe pre svoju hĺboku filozofickú a emotionálnu intenzitu.</p>'],
                ['lang' => 'en', 'content' => '<p>Slovak poet and writer. He focused mainly on modern poetry and experimental literature. His works are known for their deep philosophical and emotional intensity.</p>'],
            ],
            'image_path' => null,
        ]);
        
        // Create 8 books
        $books = Book::factory(8)->create();
        
        // Create 5 sources
        $sources = Source::factory(5)->create();
        
        // Create poems for each book (5-8 poems per book)
        foreach ($books as $book) {
            $poemCount = rand(5, 8);
            for ($i = 1; $i <= $poemCount; $i++) {
                Poem::factory()->create([
                    'book_id' => $book->id,
                    'source_id' => null,
                    'position_in_book' => $i,
                ]);
            }
        }
        
        // Create poems for sources (2-4 poems per source)
        foreach ($sources as $source) {
            $poemCount = rand(2, 4);
            Poem::factory($poemCount)->create([
                'book_id' => null,
                'source_id' => $source->id,
                'position_in_book' => null,
            ]);
        }
        
        // Create 10 unpublished poems
        Poem::factory(10)->create([
            'book_id' => null,
            'source_id' => null,
            'position_in_book' => null,
        ]);
    }
}
