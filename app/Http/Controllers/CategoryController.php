<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('books')
            ->orderBy('name')
            ->paginate(6);

        $stats = [
            'unassignedBooks' => Book::whereNull('category_id')->count(),
            'recentlyUpdated' => Category::where('updated_at', '>=', now()->subDays(30))->count(),
        ];

        return view('categories.index', [
            'categories' => $categories,
            'stats' => $stats,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request, null, 'createCategory');

        Category::create($data);

        return redirect()
            ->route('categories.index')
            ->with('status', 'Category added successfully.');
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $this->validatedData($request, $category->id, "updateCategory{$category->id}");

        $category->update($data);

        return redirect()
            ->route('categories.index')
            ->with('status', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('status', 'Category removed.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validatedData(
        Request $request,
        ?int $categoryId = null,
        ?string $errorBag = null
    ): array {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('categories', 'name')->ignore($categoryId),
            ],
            'description' => ['nullable', 'string'],
        ];

        return $errorBag
            ? $request->validateWithBag($errorBag, $rules)
            : $request->validate($rules);
    }
}

