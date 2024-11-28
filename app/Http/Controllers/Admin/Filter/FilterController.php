<?php

namespace App\Http\Controllers\Admin\Filter;

use App\Exports\CourseFilterExport;
use App\Exports\NonSubscribedUsersFilterExport;
use App\Exports\SubscribesExport;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subscribe;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FilterController extends Controller
{
    private $filterable = ['course', 'product', 'nonSubscribers'];

    public function show($filterable) {
        abort_unless(in_array($filterable, $this->filterable), 404);

        return $this->{$filterable.'Show'}();
    }

    private function courseShow() {
        $subscribes = Subscribe::query()->paginate(20);
        $export_subscribes = Subscribe::query()->with(['user', 'course'])->get();
        $courses = Course::query()->select(['id', 'title_ar', 'title_en'])->whereHas('subscribes')->get();
        $data = [
            'course_id' => null,
            'range' => null,
        ];
        return view('dashboard.filter.course', ['subscribes' => $subscribes, 'export_subscribes' => $export_subscribes, 'courses' => $courses, 'data' => $data]);
    }

    private function nonSubscribersShow() {
        $users = User::query()->whereDoesntHave('subscribes')->get();
        $data = [
            'range' => null,
        ];
        return view('dashboard.filter.nonSubscribers', ['users' => $users, 'export_users' => $users, 'data' => $data]);
    }

    public function filter(Request $request, $filterable) { // post
        abort_unless(in_array($filterable, $this->filterable), 404);
        return $this->{$filterable.'Filter'}($request);
    }

    private function courseFilter(Request $request) {
        $data = [
            'course_id' => $request->course_id,
            'range' => $request->range
        ];
        $courses = Course::query()->select(['id', 'title_ar', 'title_en'])->whereHas('subscribes')->get();
        $subscribes = Subscribe::query()->where(function ($query) use ($data) {
            if ($data['course_id'] !== null) {
                $query->where('course_id', $data['course_id']);
            }
            if ($data['range'] !== null) {
                switch ($data['range']) {
                    case 'active' :
                        $query->where('active', 1);
                        break;

                    case 'ended' :
                        $query->where('active', 0);
                        break;
                }
            }
        })->paginate(20);
        $export_subscribes = Subscribe::query()->with(['user', 'course'])->where(function ($query) use ($data) {
            if ($data['course_id'] !== null) {
                $query->where('course_id', $data['course_id']);
            }
            if ($data['range'] !== null) {
                switch ($data['range']) {
                    case 'active' :
                        $query->where('active', 1);
                        break;

                    case 'ended' :
                        $query->where('active', 0);
                        break;
                }
            }
        })->get();

        return view('dashboard.filter.course', ['subscribes' => $subscribes, 'export_subscribes' => $export_subscribes, 'courses' => $courses, 'data' => $data]);
    }
    private function nonSubscribersFilter(Request $request) {
        $data = [
            'range' => $request->range,
        ];
        $users = User::query()->whereDoesntHave('subscribes')->where(function ($query) use ($data) {
            if ($data['range'] !== null) {
                switch ($data['range']) {
                    case 'last_day':
                        $query->whereDate('created_at', '>=', Carbon::yesterday());
                        break;
                    case 'last_week':
                        $query->whereDate('created_at', '>=', Carbon::today()->subWeek());
                        break;
                    case 'last_month':
                        $query->whereDate('created_at', '>=', Carbon::today()->subMonth());
                        break;
                    case 'last_six_months':
                        $query->whereDate('created_at', '>=', Carbon::today()->subMonths(6));
                        break;
                    case 'last_year':
                        $query->whereDate('created_at', '>=', Carbon::today()->subYear());
                        break;
                    case 'last_two_years':
                        $query->whereDate('created_at', '>=', Carbon::today()->subYears(2));
                        break;
                    case 'last_three_years':
                        $query->whereDate('created_at', '>=', Carbon::today()->subYears(3));
                        break;
                }
            }
        })->get();
        return view('dashboard.filter.nonSubscribers', ['users' => $users, 'export_users' => $users, 'data' => $data]);
    }

    public function export(Request $request, $filterable) {
        abort_unless(in_array($filterable, $this->filterable), 404);
        return $this->{$filterable.'Export'}($request);
    }

    private function courseExport(Request $request) {
        try {
            return Excel::download(new CourseFilterExport($request->data), 'subscribes.xlsx');
        } catch(Exception $ex) {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    private function nonSubscribersExport(Request $request) {
        try {
            return Excel::download(new NonSubscribedUsersFilterExport($request->data), 'users-not-subscribed.xlsx');
        } catch(Exception $ex) {
            dd($ex);
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
