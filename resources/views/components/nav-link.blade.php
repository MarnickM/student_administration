@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-t-2 border-red-700 text-sm font-medium leading-5 text-gray-700 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-t-2 border-transparent text-sm font-medium leading-5 text-gray-900 hover:text-red-700 hover:border-red-700 focus:outline-none focus:text-gray-700 focus:border-red-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
