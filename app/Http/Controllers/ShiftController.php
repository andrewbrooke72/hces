<?php

namespace HCES\Http\Controllers;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use HCES\Employee;
use HCES\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ShiftController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permissions:sysvar.management');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shifts = Shift::paginate(100);
        return view('pages.shifts.index')->with('shifts', $shifts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.shifts.create');
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
                'name' => 'required',
                'from' => 'required',
                'to' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect(route('shifts.create'))
                    ->withErrors($validator)
                    ->withInput();
            }
            $data = $request->all();
            $shift = new Shift($data);
            $shift->save();
            DB::commit();
            return redirect(route('shifts.index'))
                ->with('status_success', 'Shift created!');
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
        $shift = Shift::find($id);
        return view('pages.shifts.edit')->with('shift', $shift);
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
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'from' => 'required',
                'to' => 'required',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = $request->all();
            $shift = Shift::find($id);
            $shift->fill($data);
            $shift->save();
            DB::commit();
            return redirect(route('shifts.index'))
                ->with('status_success', 'Shift updated!');
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            DB::rollBack();
            return back()->with('status_error', 'Update failed: ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $shift = Shift::with('employees')->find($id);
            foreach ($shift->employees as $employee) {
                $employee->shift_id = null;
                $employee->save();
            }
            $shift->delete();
            DB::commit();
            return redirect(route('shifts.index'))
                ->with('status_success', 'Shift deleted!');
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            DB::rollBack();
            return back()->with('status_error', 'Delete failed: ' . $exception->getMessage());
        }
    }
}
