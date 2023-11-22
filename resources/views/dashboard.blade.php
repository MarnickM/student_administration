<x-student-administration-layout>
    <x-slot name="description">dashboard</x-slot>
    <x-slot name="title">{{ auth()->user()->name }}'s Dashboard</x-slot>

    <x-tmk.section>
        <x-welcome/>
    </x-tmk.section>
</x-student-administration-layout>
