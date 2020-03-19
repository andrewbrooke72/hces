<?php

namespace HCES\Http\Controllers;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Carbon\Carbon;
use HCES\Department;
use HCES\Employee;
use HCES\Position;
use HCES\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permissions:employee.management');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::with('shift', 'position', 'department')->orderBy('is_active', 'desc')->paginate(100);
        return view('pages.employees.index')->with('employees', $employees);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shifts = Shift::all();
        $departments = Department::all();
        $positions = Position::all();
        return view('pages.employees.create')->with([
            'shifts' => $shifts,
            'departments' => $departments,
            'positions' => $positions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'photo' => 'image',
                'employee_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'middle_name' => 'required',
                'gender' => 'required',
                'date_of_birth' => 'required',
                'age' => 'required',
                'permanent_address' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect(route('employees.create'))
                    ->withErrors($validator)
                    ->withInput();
            }
            $data = $request->all();
            $file_name = $data['employee_id'] . Carbon::now()->format('ymdhis');
            $employee = new Employee($data);
            $employee->save();
            Image::make($data['photo'])->resize(360, 360)->save(Storage::disk('employee_photos')->getAdapter()->getPathPrefix() . '' . $file_name . '.jpg');
            $employee->photo = $file_name . '.jpg';
            $employee->save();
            DB::commit();
            return redirect(route('employees.index'))->with('status_success', 'Employee Created!');
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            DB::rollBack();
            return back()->with('status_error', 'Creation failed: ' . $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
