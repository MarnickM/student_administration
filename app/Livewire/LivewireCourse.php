<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Programme;
//use Livewire\Attributes\Layout;
use App\Models\Student;
use App\Models\StudentCourse;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class LivewireCourse extends Component
{
    use WithPagination;

    public $loading = 'Please wait...';
    public $perPage = 6;

    public $name;

    public $programme = '%'; //zet op % zodat je alles toont wanneer er nog geen filter is toegevoegd
    public $selectedCourse;
    public $showModal = false;

    public $selectedProgramme = '';

    public function showCourse(Course $course) // je geeft $course mee, dit bevat de content van de tabel course,
        // heb je nodig wanneer je klikt op een button
    {
        $this->selectedCourse = $course;
        $this->showModal = true;
        //$this->selectedCourse['courses'] = $course['studentcourses']; dit geef je al mee in de functie render()
        $this->selectedCourse['students'] = Student::get(); //plaats alle studenten in deze array om ze dan te kunnen tonen
        //dump($this->selectedCourse->toArray());
    }

    #[Layout('layouts.student-administration-layout', ['title' => 'Courses', 'description' => 'Welcome to student administration'])]

    public function render()
    {
//        sleep(2);
        $courses = Course::orderBy('name')
//            ->with('programme')
            ->with('programme') //geef de programme tabel mee
            ->with('studentcourses') //geef de studentcourses tabel mee, dit kunnen we dan
            // ook oproepen via Course $course in de functie showCourse en zo bereiken
            ->searchNameOrDescription($this->name)
            ->where('id', 'like', $this->programme)
            ->paginate($this->perPage);
//            ->get();
        $programmes = Programme::get();
        $this->selectedProgramme = ($this->programme !== '%') ? Programme::find($this->programme)->name : '';

        return view('livewire.livewire-course',
            compact('courses','programmes')); // geef de variabelen door
        // naar de view om ze daar te gebruiken (in livewire-course.blade.php)
    }
}
