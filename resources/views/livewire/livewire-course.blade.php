<div>
    {{-- show preloader while fetching data in the background --}}
    <div class="fixed top-8 left-1/2 -translate-x-1/2 z-50 animate-pulse"
         wire:loading>
        <x-tmk.preloader class="bg-lime-700/60 text-white border border-lime-700 shadow-2xl">
            {{ $loading }}
        </x-tmk.preloader>
    </div>

    {{-- filter section: artist or title, genre, max price and records per page --}}

    {{-- master section: cards with paginationlinks --}}
    <div class="my-4">{{ $courses->links() }}</div>
    <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-8 mt-8">
        @foreach ($courses as $course)

            <div wire:key="course-{{ $course->id }}" class="flex bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden">

                <div class="flex-1 flex flex-col">
                    <div class="flex-1 p-4">
                        <p class="text-center p-2">{{ $course->programme->name }}</p>
                        <p class="text-lg font-bold py-5">{{ $course->name }}</p>
                        <p class="pb-2">{{ $course->description }}</p>
                    </div>
                    <div class="border-t border-gray-300 bg-gray-100 px-4 py-2">
                        <div>
                            <button class="px-6 py-2 text-white bg-blue-600 rounded">Manage students</button>
                        </div>
                    </div>
                </div>
            </div>
    @endforeach
    </div>

    <x-tmk.livewire-log :courses="$courses" />

    {{-- Detail section --}}
</div>
