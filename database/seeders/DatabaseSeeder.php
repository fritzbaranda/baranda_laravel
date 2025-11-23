<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $categories = collect([
            [
                'name' => 'Fiction',
                'description' => 'Imaginative works of prose, especially novels, that describe imaginary events and people.',
            ],
            [
                'name' => 'Science Fiction',
                'description' => 'Fiction based on imagined future scientific or technological advances and major social or environmental changes.',
            ],
            [
                'name' => 'Mystery',
                'description' => 'A genre of fiction in which a detective, or other professional, solves a crime or series of crimes.',
            ],
            [
                'name' => 'Biography',
                'description' => 'An account of someone\'s life written by someone else.',
            ],
            [
                'name' => 'History',
                'description' => 'The study of past events, particularly in human affairs.',
            ],
        ])
            ->map(fn (array $data) => Category::create($data))
            ->values();

        $books = [
            [
                'isbn' => '978-0-123456-78-9',
                'title' => 'The Great Adventure',
                'author' => 'Jane Smith',
                'publisher' => 'Literary Press',
                'publication_year' => 2023,
                'pages' => 350,
                'description' => 'An epic tale of adventure and discovery.',
                'category_id' => $categories[0]->id,
            ],
            [
                'isbn' => '978-0-234567-89-0',
                'title' => 'Stars Beyond',
                'author' => 'Robert Johnson',
                'publisher' => 'Sci-Fi Books',
                'publication_year' => 2022,
                'pages' => 420,
                'description' => 'A journey through the cosmos and beyond.',
                'category_id' => $categories[1]->id,
            ],
            [
                'isbn' => '978-0-345678-90-1',
                'title' => 'The Hidden Clue',
                'author' => 'Sarah Williams',
                'publisher' => 'Mystery House',
                'publication_year' => 2024,
                'pages' => 280,
                'description' => 'A detective story full of twists and turns.',
                'category_id' => $categories[2]->id,
            ],
            [
                'isbn' => '978-0-456789-01-2',
                'title' => 'Life of a Leader',
                'author' => 'Michael Brown',
                'publisher' => 'Biography Press',
                'publication_year' => 2021,
                'pages' => 500,
                'description' => 'The inspiring story of a great leader.',
                'category_id' => $categories[3]->id,
            ],
            [
                'isbn' => '978-0-567890-12-3',
                'title' => 'World Wars: A History',
                'author' => 'Emily Davis',
                'publisher' => 'Historical Books',
                'publication_year' => 2020,
                'pages' => 600,
                'description' => 'A comprehensive account of the world wars.',
                'category_id' => $categories[4]->id,
            ],
            [
                'isbn' => '978-0-678901-23-4',
                'title' => 'The Lost City',
                'author' => 'David Miller',
                'publisher' => 'Adventure Publishing',
                'publication_year' => 2023,
                'pages' => 320,
                'description' => 'An adventure novel about discovering ancient secrets.',
                'category_id' => $categories[0]->id,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
