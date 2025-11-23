<x-layouts.app :title="__('Library Dashboard')">
    <div class="space-y-8">
        @if (session('status'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-900 dark:border-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-100">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm font-medium text-zinc-500">Total Books</p>
                <p class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">
                    {{ number_format($stats['totalBooks']) }}
                </p>
                <p class="text-xs text-zinc-500">All books in collection</p>
            </div>
            <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm font-medium text-zinc-500">Active Categories</p>
                <p class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">
                    {{ number_format($stats['activeCategories']) }}
                </p>
                <p class="text-xs text-zinc-500">With at least one book</p>
            </div>
            <div class="rounded-2xl border border-indigo-200 bg-indigo-50 p-6 shadow-sm dark:border-indigo-800 dark:bg-indigo-900/40">
                <p class="text-sm font-medium text-indigo-700 dark:text-indigo-200">Enrollment Rate</p>
                <p class="mt-3 text-3xl font-semibold text-indigo-900 dark:text-white">
                    {{ $stats['enrollmentRate'] }}
                </p>
                <p class="text-xs text-indigo-700/80 dark:text-indigo-100/70">Library utilization</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Add New Book</h2>
                        <p class="text-sm text-zinc-500">Complete all required book details</p>
                    </div>
                    <span class="text-xs font-semibold uppercase text-emerald-600">Form</span>
                </div>

                @if ($errors->getBag('createBook')->isNotEmpty())
                    <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-sm text-rose-700 dark:border-rose-800 dark:bg-rose-900/40 dark:text-rose-100">
                        <p class="font-semibold">Please correct the fields below.</p>
                        <ul class="list-disc pl-5">
                            @foreach ($errors->getBag('createBook')->all() as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('books.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Standard Book Number (SBN)</label>
                            <input
                                type="text"
                                name="isbn"
                                value="{{ old('isbn') }}"
                                class="mt-1 w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                placeholder=""
                                required
                            />
                            @error('isbn', 'createBook')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Author</label>
                            <input
                                type="text"
                                name="author"
                                value="{{ old('author') }}"
                                class="mt-1 w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                placeholder="Author Name"
                                required
                            />
                            @error('author', 'createBook')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Title</label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            class="mt-1 w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                            placeholder="Title of The Book"
                            required
                        />
                        @error('title', 'createBook')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid gap-4 md:grid-cols-3">
                        <div>
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Category</label>
                            <select
                                name="category_id"
                                class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                            >
                                <option value="">Uncategorized</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id', 'createBook')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Publisher</label>
                            <input
                                type="text"
                                name="publisher"
                                value="{{ old('publisher') }}"
                                class="mt-1 w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                placeholder="Publisher Name"
                            />
                            @error('publisher', 'createBook')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Publication Year</label>
                            <input
                                type="number"
                                name="publication_year"
                                value="{{ old('publication_year') }}"
                                min="1000"
                                max="{{ date('Y') }}"
                                class="mt-1 w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                placeholder="Published Year"
                            />
                            @error('publication_year', 'createBook')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Pages</label>
                            <input
                                type="number"
                                step="1"
                                min="1"
                                name="pages"
                                value="{{ old('pages') }}"
                                class="mt-1 w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                placeholder=""
                            />
                            @error('pages', 'createBook')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Description</label>
                            <textarea
                                name="description"
                                rows="3"
                                class="mt-1 w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                placeholder=""
                            >{{ old('description') }}</textarea>
                            @error('description', 'createBook')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <button
                            type="submit"
                            class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                            Save Book
                        </button>
                    </div>
                </form>
            </div>

            <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Recent Additions</h2>
                <p class="text-sm text-zinc-500">Last three books added</p>

                <ul class="mt-5 space-y-4">
                    @forelse ($recentBooks as $book)
                        <li class="rounded-xl border border-zinc-200 p-3 text-sm dark:border-zinc-700">
                            <p class="font-semibold text-zinc-900 dark:text-white">{{ $book->title }}</p>
                            <p class="text-xs text-zinc-500">{{ $book->author }} · {{ $book->category->name ?? 'Uncategorized' }}</p>
                            <p class="text-xs text-zinc-500">Added: {{ $book->created_at->format('M d, Y') }}</p>
                        </li>
                    @empty
                        <li class="rounded-xl border border-dashed border-zinc-300 p-4 text-sm text-zinc-500 dark:border-zinc-700">
                            No books added yet.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Book Directory</h2>
                    <p class="text-sm text-zinc-500">Track every book with related category and details.</p>
                </div>
                <span class="text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ $books->total() }} records</span>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 text-sm dark:divide-zinc-700">
                    <thead class="bg-zinc-50 text-xs uppercase tracking-wide text-zinc-500 dark:bg-zinc-800 dark:text-zinc-300">
                        <tr>
                            <th class="px-4 py-3 text-left">Book</th>
                            <th class="px-4 py-3 text-left">Category</th>
                            <th class="px-4 py-3 text-left">Author</th>
                            <th class="px-4 py-3 text-left">Publisher</th>
                            <th class="px-4 py-3 text-left">Year</th>
                            <th class="px-4 py-3 text-left">Pages</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @forelse ($books as $book)
                            @php
                                $bag = "updateBook{$book->id}";
                                $bagHasErrors = $errors->getBag($bag)->isNotEmpty();
                            @endphp
                            <tr class="align-top">
                                <td class="px-4 py-4">
                                    <div class="font-semibold text-zinc-900 dark:text-white">{{ $book->title }}</div>
                                    <div class="text-xs text-zinc-500">{{ $book->isbn }}</div>
                                </td>
                                <td class="px-4 py-4 text-zinc-700 dark:text-zinc-100">
                                    {{ $book->category->name ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-4 text-zinc-700 dark:text-zinc-100">
                                    {{ $book->author }}
                                </td>
                                <td class="px-4 py-4 text-zinc-700 dark:text-zinc-100">
                                    {{ $book->publisher ?? '—' }}
                                </td>
                                <td class="px-4 py-4 text-zinc-700 dark:text-zinc-100">
                                    {{ $book->publication_year ?? '—' }}
                                </td>
                                <td class="px-4 py-4 text-zinc-700 dark:text-zinc-100">
                                    {{ $book->pages ?? '—' }}
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <flux:modal.trigger name="edit-book-{{ $book->id }}">
                                            <flux:button
                                                size="sm"
                                                variant="filled"
                                                x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'edit-book-{{ $book->id }}')"
                                            >
                                                Edit
                                            </flux:button>
                                        </flux:modal.trigger>

                                        <form
                                            method="POST"
                                            action="{{ route('books.destroy', $book) }}"
                                            onsubmit="return confirm('Delete {{ $book->title }}?');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <flux:button size="sm" variant="danger" type="submit">
                                                Delete
                                            </flux:button>
                                        </form>
                                    </div>

                                    <flux:modal
                                        name="edit-book-{{ $book->id }}"
                                        :show="$errors->getBag($bag)->isNotEmpty()"
                                        class="max-w-3xl"
                                    >
                                        <form
                                            method="POST"
                                            action="{{ route('books.update', $book) }}"
                                            class="space-y-4"
                                        >
                                            @csrf
                                            @method('PUT')

                                            <div class="flex items-start justify-between gap-4">
                                                <div>
                                                    <flux:heading size="lg">
                                                        Edit {{ $book->title }}
                                                    </flux:heading>
                                                    <flux:subheading>
                                                        Update book details and category.
                                                    </flux:subheading>
                                                </div>

                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Close</flux:button>
                                                </flux:modal.close>
                                            </div>

                                            <div class="grid gap-4 md:grid-cols-2">
                                                <div>
                                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">ISBN</label>
                                                    <input
                                                        type="text"
                                                        name="isbn"
                                                        value="{{ $bagHasErrors ? old('isbn') : $book->isbn }}"
                                                        class="mt-1 w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                                        required
                                                    />
                                                    @error('isbn', $bag)
                                                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Author</label>
                                                    <input
                                                        type="text"
                                                        name="author"
                                                        value="{{ $bagHasErrors ? old('author') : $book->author }}"
                                                        class="mt-1 w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                                        required
                                                    />
                                                    @error('author', $bag)
                                                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div>
                                                <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Title</label>
                                                <input
                                                    type="text"
                                                    name="title"
                                                    value="{{ $bagHasErrors ? old('title') : $book->title }}"
                                                    class="mt-1 w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                                    required
                                                />
                                                @error('title', $bag)
                                                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="grid gap-4 md:grid-cols-3">
                                                <div>
                                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Category</label>
                                                    @php
                                                        $categoryValue = $bagHasErrors ? old('category_id') : $book->category_id;
                                                    @endphp
                                                    <select
                                                        name="category_id"
                                                        class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                                    >
                                                        <option value="">Uncategorized</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}" @selected($categoryValue == $category->id)>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id', $bag)
                                                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Publisher</label>
                                                    <input
                                                        type="text"
                                                        name="publisher"
                                                        value="{{ $bagHasErrors ? old('publisher') : $book->publisher }}"
                                                        class="mt-1 w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                                    />
                                                    @error('publisher', $bag)
                                                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Publication Year</label>
                                                    <input
                                                        type="number"
                                                        name="publication_year"
                                                        min="1000"
                                                        max="{{ date('Y') }}"
                                                        value="{{ $bagHasErrors ? old('publication_year') : $book->publication_year }}"
                                                        class="mt-1 w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                                    />
                                                    @error('publication_year', $bag)
                                                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="grid gap-4 md:grid-cols-2">
                                                <div>
                                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Pages</label>
                                                    <input
                                                        type="number"
                                                        step="1"
                                                        min="1"
                                                        name="pages"
                                                        value="{{ $bagHasErrors ? old('pages') : $book->pages }}"
                                                        class="mt-1 w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                                    />
                                                    @error('pages', $bag)
                                                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Description</label>
                                                    <textarea
                                                        name="description"
                                                        rows="3"
                                                        class="mt-1 w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                                    >{{ $bagHasErrors ? old('description') : $book->description }}</textarea>
                                                    @error('description', $bag)
                                                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="flex items-center justify-end gap-2">
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                </flux:modal.close>
                                                <flux:button variant="primary" type="submit">
                                                    Update Book
                                                </flux:button>
                                            </div>
                                        </form>
                                    </flux:modal>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-sm text-zinc-500 dark:text-zinc-300">
                                    No books yet. Use the form above to create the first record.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $books->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
