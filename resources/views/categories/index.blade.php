<x-layouts.app :title="__('Categories')">
    <div class="space-y-8">
        @if (session('status'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-900 dark:border-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-100">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm font-medium text-zinc-500">Categories</p>
                <p class="mt-3 text-3xl font-semibold text-zinc-900 dark:text-white">{{ number_format($categories->total()) }}</p>
                <p class="text-xs text-zinc-500">Active book categories</p>
            </div>
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-6 shadow-sm dark:border-amber-800 dark:bg-amber-900/40">
                <p class="text-sm font-medium text-amber-700 dark:text-amber-200">Uncategorized Books</p>
                <p class="mt-3 text-3xl font-semibold text-amber-900 dark:text-white">{{ number_format($stats['unassignedBooks']) }}</p>
                <p class="text-xs text-amber-700/80 dark:text-amber-100/80">Need category assignment</p>
            </div>
            <div class="rounded-2xl border border-indigo-200 bg-indigo-50 p-6 shadow-sm dark:border-indigo-800 dark:bg-indigo-900/40">
                <p class="text-sm font-medium text-indigo-700 dark:text-indigo-100">Recently Updated</p>
                <p class="mt-3 text-3xl font-semibold text-indigo-900 dark:text-white">{{ number_format($stats['recentlyUpdated']) }}</p>
                <p class="text-xs text-indigo-700/80 dark:text-indigo-100/70">Touched in the last 30 days</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Add Category</h2>
                <p class="text-sm text-zinc-500">Define book categories and descriptions.</p>

                @if ($errors->getBag('createCategory')->isNotEmpty())
                    <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-sm text-rose-700 dark:border-rose-800 dark:bg-rose-900/40 dark:text-rose-100">
                        <p class="font-semibold">Please fix the highlighted fields.</p>
                        <ul class="list-disc pl-5">
                            @foreach ($errors->getBag('createCategory')->all() as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('categories.store') }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Name</label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="mt-1 w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                            required
                        />
                        @error('name', 'createCategory')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Description</label>
                        <textarea
                            name="description"
                            rows="4"
                            class="mt-1 w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                            placeholder=""
                        >{{ old('description') }}</textarea>
                        @error('description', 'createCategory')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                        Create Category
                    </button>
                </form>
            </div>

            <div class="lg:col-span-2 rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Category Directory</h2>
                        <p class="text-sm text-zinc-500">Manage the categories that books belong to.</p>
                    </div>
                    <span class="text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ $categories->total() }} total</span>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 text-sm dark:divide-zinc-700">
                        <thead class="bg-zinc-50 text-xs uppercase tracking-wide text-zinc-500 dark:bg-zinc-800 dark:text-zinc-300">
                            <tr>
                                <th class="px-4 py-3 text-left">Category</th>
                                <th class="px-4 py-3 text-left">Books</th>
                                <th class="px-4 py-3 text-left">Description</th>
                                <th class="px-4 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @forelse ($categories as $category)
                                @php
                                    $bag = "updateCategory{$category->id}";
                                    $bagHasErrors = $errors->getBag($bag)->isNotEmpty();
                                @endphp
                                <tr class="align-top">
                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-zinc-900 dark:text-white">{{ $category->name }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-zinc-700 dark:text-zinc-100">
                                        {{ $category->books_count }} {{ \Illuminate\Support\Str::plural('book', $category->books_count) }}
                                    </td>
                                    <td class="px-4 py-4 text-zinc-700 dark:text-zinc-100">
                                        {{ $category->description ?? 'No description' }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            <flux:modal.trigger name="edit-category-{{ $category->id }}">
                                                <flux:button
                                                    size="sm"
                                                    variant="filled"
                                                    x-data=""
                                                    x-on:click.prevent="$dispatch('open-modal', 'edit-category-{{ $category->id }}')"
                                                >
                                                    Edit
                                                </flux:button>
                                            </flux:modal.trigger>
                                            <form
                                                method="POST"
                                                action="{{ route('categories.destroy', $category) }}"
                                                onsubmit="return confirm('Delete {{ $category->name }}?');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <flux:button size="sm" variant="danger" type="submit">
                                                    Delete
                                                </flux:button>
                                            </form>
                                        </div>

                                        <flux:modal
                                            name="edit-category-{{ $category->id }}"
                                            :show="$errors->getBag($bag)->isNotEmpty()"
                                            class="max-w-2xl"
                                        >
                                            <form
                                                method="POST"
                                                action="{{ route('categories.update', $category) }}"
                                                class="space-y-4"
                                            >
                                                @csrf
                                                @method('PUT')

                                                <div class="flex items-start justify-between gap-4">
                                                    <div>
                                                        <flux:heading size="lg">Update {{ $category->name }}</flux:heading>
                                                        <flux:subheading>Keep category metadata accurate.</flux:subheading>
                                                    </div>
                                                    <flux:modal.close>
                                                        <flux:button variant="ghost">Close</flux:button>
                                                    </flux:modal.close>
                                                </div>

                                                <div>
                                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Name</label>
                                                    <input
                                                        type="text"
                                                        name="name"
                                                        value="{{ $bagHasErrors ? old('name') : $category->name }}"
                                                        class="mt-1 w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                                        required
                                                    />
                                                    @error('name', $bag)
                                                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-100">Description</label>
                                                    <textarea
                                                        name="description"
                                                        rows="4"
                                                        class="mt-1 w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                                    >{{ $bagHasErrors ? old('description') : $category->description }}</textarea>
                                                    @error('description', $bag)
                                                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <div class="flex items-center justify-end gap-2">
                                                    <flux:modal.close>
                                                        <flux:button variant="ghost">Cancel</flux:button>
                                                    </flux:modal.close>
                                                    <flux:button variant="primary" type="submit">
                                                        Update Category
                                                    </flux:button>
                                                </div>
                                            </form>
                                        </flux:modal>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-sm text-zinc-500 dark:text-zinc-300">
                                        No categories yet. Use the form on the left to create one.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

