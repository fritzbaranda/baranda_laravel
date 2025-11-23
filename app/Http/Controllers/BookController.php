<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    public function index(): View
    {
        $books = Book::with('category')
            ->latest()
            ->paginate(8);

        $categories = Category::orderBy('name')->get();

        $stats = [
            'totalBooks' => Book::count(),
            'activeCategories' => Category::count(),
            'enrollmentRate' => '94%', // Static as per requirements
        ];

        $recentBooks = Book::orderByDesc('created_at')
            ->limit(3)
            ->get();

        return view('dashboard', [
            'books' => $books,
            'categories' => $categories,
            'stats' => $stats,
            'recentBooks' => $recentBooks,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request, null, 'createBook');

        Book::create($data);

        return redirect()
            ->route('dashboard')
            ->with('status', 'Book added successfully.');
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $data = $this->validatedData($request, $book->id, "updateBook{$book->id}");

        $book->update($data);

        return redirect()
            ->route('dashboard')
            ->with('status', 'Book updated successfully.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()
            ->route('dashboard')
            ->with('status', 'Book removed.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validatedData(
        Request $request,
        ?int $bookId = null,
        ?string $errorBag = null
    ): array {
        $rules = [
            'category_id' => ['nullable', 'exists:categories,id'],
            'isbn' => [
                'required',
                'max:50',
                Rule::unique('books', 'isbn')->ignore($bookId),
            ],
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'publication_year' => ['nullable', 'integer', 'min:1000', 'max:' . date('Y')],
            'pages' => ['nullable', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
        ];

        return $errorBag
            ? $request->validateWithBag($errorBag, $rules)
            : $request->validate($rules);
    }
}

