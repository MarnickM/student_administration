<div>
    {{-- show preloader while fetching data in the background --}}
    <div class="fixed top-8 left-1/2 -translate-x-1/2 z-50 animate-pulse"
         wire:loading>
        <x-tmk.preloader class="bg-lime-700/60 text-white border border-lime-700 shadow-2xl">
            {{ $loading }}
        </x-tmk.preloader>
    </div>

    {{-- filter section: artist or title, genre, max price and records per page --}}
    <div class="grid grid-cols-9 gap-4">
{{--        verdeel hoofd div in kolommen (9), en zeg dan dat de 3 filters elk 3 kolommen nemen voor een goede verdeling--}}
        <div class="col-span-12 md:col-span-12 lg:col-span-3">
            <x-label for="name" value="Filter"/>
            <div
                class="relative">
                <x-input id="name" type="text"
                         wire:model.live.debounce.500ms="name"
                         class="block mt-1 w-full"
                         placeholder="Filter on course name or description"/>
                <button
                    @click="$wire.set('name', '')"
                    class="w-5 absolute right-4 top-3">
                    <x-phosphor-x/>
                </button>
            </div>
        </div>
        <div class="col-span-12 md:col-span-6 lg:col-span-3">
            <x-label for="genre" value="Programme"/>
            <x-tmk.form.select id="genre"
                               wire:model.live="programme"
                               class="block mt-1 w-full">
                <option value="%">All Programmes</option>
                @foreach($programmes as $p)
                    <option value="{{ $p->id }}">
                        {{ $p->name }}
                    </option>
                @endforeach
            </x-tmk.form.select>
        </div>
        <div class="col-span-12 md:col-span-6 lg:col-span-3">
            <x-label for="perPage" value="Courses per page"/>
            <x-tmk.form.select id="perPage"
                               wire:model.live="perPage"
                               class="block mt-1 w-full">
                @foreach ([1,2,3,6,7] as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </x-tmk.form.select>
        </div>
    </div>

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
                            @if($course['studentcourses'][0] ?? '') {{--als dit leeg is dan zijn er geen studenten voor dit vak--}}
                                <button wire:click="showCourse({{ $course->id }})" class="w-full px-6 py-2 text-white bg-blue-600 rounded">Manage students</button>
                            @else
                                <button class="w-full px-6 py-2 text-white bg-blue-600 opacity-25 rounded " disabled >Manage students</button>
                            @endif
                        </div>
{{--                        Alternatieve butten door x-button te gebruiken, de opbouw van de button bevindt zich dan in x.tmk.form.button--}}
{{--                        @if($course['studentcourses'][0] ?? "")--}}
{{--                            --}}{{-- Als studentcourses'][0] leeg is dan is studentcourses leeg en zijn er geen studenten --}}
{{--                            <x-tmk.form.button class="w-full justify-center !py-5" color="blue"--}}
{{--                                               wire:click="showCourse({{ $course->id }})"> --}}{{-- Dit snap ik niet wire:click="showCourse({{ $course->id }})" waarom werkt het met id. De Course van showCourse verwacht een id daarom geven we de id mee. Het werkt nogsteeds bij mij maar ik geef gewoon teveel info meer (de hele array)--}}
{{--                                Manage students--}}
{{--                            </x-tmk.form.button>--}}
{{--                        @else--}}
{{--                            <x-tmk.form.button class="w-full justify-center !py-5" color="blue" disabled>--}}
{{--                                Manage students--}}
{{--                            </x-tmk.form.button>--}}
{{--                        @endif--}}
                    </div>
                </div>
            </div>
    @endforeach
    </div>

    <x-tmk.livewire-log :courses="$courses" />
    {{--No courses found--}}
    @if($selectedProgramme !== '' )
        @if($courses->isEmpty())
            <x-tmk.alert type="danger" class="w-full">
                Can't find course with <b>'{{ $name }}'</b> for the programme <b>'{{ $selectedProgramme }}'</b>
            </x-tmk.alert>
        @endif
    @else
        @if($courses->isEmpty())
            <x-tmk.alert type="danger" class="w-full">
                Can't find course with <b>'{{ $name }}'</b>
            </x-tmk.alert>
        @endif
    @endif

    {{-- Detail section --}}
    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            <div class="items-center border-b border-gray-300 pb-2 gap-4">
                <h3 class="font-bold">{{ $selectedCourse->name ?? '' }}</h3>
                <br>
                <p class="font-normal py-2">{{ $selectedCourse->description ?? '' }}</p>
            </div>
        </x-slot>
        <hr>
        <x-slot name="content"> {{--check hier of er students zijn, doe niet selectedCourse->studentcourses want
        dan krijg je een error als je van pagina switched want het object "studentcourses" bestaat altijd
        dus zal de check gebypassed worden en kan de foreach($selectedCourse['studentcourses'] as $stcourse) runnen
        en zal er een error komen wanneer er een lege array is

         {{--Ali:  Check of students (de studentcourse array) leeg is of niet, als het leeg is ga je niet in de if.
         We hebben het nu studentcourses gemaakt, hierdoor krijgen we een error. Nu hebben we het naar students gezet want anders zou je altijd in de if
            komen omdat studentcourses nu gewoon altijd bestaat dus het is alsof er geen if is--}}
            @isset($selectedCourse->students) {{--variable['item'] gebruik je als je met arrays wilt werken!--}}
                @foreach($selectedCourse['studentcourses'] as $stcourse) {{--je gaat hier al de courses inladen en steken in de variabele stcourse (array)--}}
{{--                <p class="font-normal py-2">{{$stcourses['student_id']}}</p>--}}

                    @foreach($selectedCourse['students'] as $students) {{--nu ga je al de studenten in de variabele students steken (array)--}}
                        @if($stcourse['student_id'] === $students['id']) {{--kijk waar de studenten id's van de courses overeen komen met de
                        studenten id's van al de studenten, dit zijn dan de studenten die deze course volgen, zo filter je--}}
                                <p>{{$students['first_name']}}
                                    {{$students['last_name']}}
                                    (semester {{$stcourse['semester']}})</p> {{--print de juiste info door deze op te halen uit de arrays--}}
                        @endif
                    @endforeach
                @endforeach
            @endisset
        </x-slot>
        <x-slot name="footer"></x-slot>

    </x-dialog-modal>
</div>
