<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Programme;
//use Livewire\Attributes\Layout;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class LivewireCourse extends Component
{
    use WithPagination;

    public $loading = 'Please wait...';
    public $perpage = 4;
    public $selectedCourse;
    public $showModal = false;

    public function showCourse(Course $course)
    {
        $this->selectedCourse = $course;
        $this->showModal = true;
        $this->selectedCourse['students'] = $course['studentcourses'][1];
//        dump($this->selectedCourse->toArray());
    }

    #[Layout('layouts.student-administration-layout', ['title' => 'Courses', 'description' => 'Welcome to student administration'])]

    public function render()
    {
//        sleep(2);
        $courses = Course::orderBy('name')
//            ->with('programme')
            ->with('programme')
            ->paginate($this->perpage);
//            ->get();
        $programmes = Programme::get();

        return view('livewire.livewire-course', compact('courses','programmes'));
    }
}
