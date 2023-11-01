<nav class="container p-4 flex justify-start mx-auto items-center space-x-4">
    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">Home</x-nav-link>
    <x-nav-link href="{{ route('courses') }}" :active="request()->routeIs('courses')">Courses</x-nav-link>
</nav>
