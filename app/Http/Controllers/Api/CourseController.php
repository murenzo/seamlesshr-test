<?php

namespace App\Http\Controllers\Api;

use App\Course;
use Illuminate\Http\Request;
use App\Exports\CourseExport;
use App\Jobs\PopulateCourseTable;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Api\Controller;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.token');
    }

    public function index()
    {
        return Course::all()->toArray();
    }

    public function populate()
    {
        $status = $this->dispatch(new PopulateCourseTable());

        if (!$status) {
            return response()->json(['status' => 500, 'message' => 'Something went wrong. Try again'], 500);
        }

        return response()->json(['status' => 200, 'message' => 'Populating the course table has been queued successfully'], 200);
    }

    public function register(Request $request)
    {
        $courseIds =  $request['courseIds'];

        if (!$courseIds || $this->hasAlienCourseIds($courseIds)) {
            return response()->json(['status' => 400, 'message' => 'Bad request'], 400);
        }

        try {
            auth()->getUser()->courses()->attach($courseIds);
        } catch (QueryException $e) {
            return response()->json(['status' => 500, 'message' => 'Hope you are not trying to register a course twice'], 500);
        }


        return response()->json(['status' => 200, 'message' => 'Course registeration successful'], 200);
    }

    public function download()
    {
        return Excel::download(new CourseExport, 'courses.csv');
    }

    private function hasAlienCourseIds(array $courseIds)
    {
        return array_diff($courseIds, Course::pluck('id')->toArray());
    }
}
