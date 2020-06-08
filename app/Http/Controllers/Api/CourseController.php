<?php

namespace App\Http\Controllers\Api;

use App\Course;
use Illuminate\Http\Request;
use App\Jobs\PopulateCourseTable;
use App\Http\Controllers\Api\Controller;
use Illuminate\Database\QueryException;

class CourseController extends Controller
{
    public function index()
    {
        return Course::all()->toArray();
    }

    public function populate()
    {
        if (!$auth = $this->isLoggedIn()) {
            $status = $this->dispatch(new PopulateCourseTable());

            if (!$status) {
                return response()->json(['status' => 500, 'message' => 'Something went wrong. Try again'], 500);
            }

            return response()->json(['status' => 200, 'message' => 'Populating the course table has been queued successfully'], 200);
        }

        return response()->json(['status' => 401, 'message' => $auth], 401);
    }

    public function register(Request $request)
    {
        $courseIds =  $request['courseIds'];

        if (!$auth = $this->isLoggedIn()) {

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

        return response()->json(['status' => 401, 'message' => $auth], 401);
    }

    private function hasAlienCourseIds(array $courseIds)
    {
        return array_diff($courseIds, Course::pluck('id')->toArray());
    }

    private function isLoggedIn()
    {
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return 'User unauthorized';
        }

        return false;
    }
}
