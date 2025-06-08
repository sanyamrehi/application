<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gallery') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-semibold mb-4">Image Gallery</h1>

                    <div class="flex justify-end mb-4">
                     <a href="{{ route('application.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
        <i class="fas fa-list"></i> Application Index
    </a>
                        <a href="{{ route('gallery.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                            <i class="fas fa-plus"></i> Create New Application
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @forelse ($galleries as $gallery)

                            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                                <img src="{{ asset('/app_images/' . $gallery->image) }}" class="w-full h-64 object-cover" alt="Gallery Image">
                                <div class="p-4 text-center">
                                    <span class="px-3 py-1 text-sm font-semibold rounded
                                        {{ $gallery->status == 'Active' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                        {{ $gallery->status }}
                                    </span>
                                    <div class="mt-3 flex justify-center gap-2">
                                        <a href="{{ route('gallery.edit', $gallery->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('gallery.delete', $gallery->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded" onclick="return confirm('Are you sure?');">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center text-gray-500">No gallery images found.</div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 flex justify-center">
                        {{ $galleries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
