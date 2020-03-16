<?php

namespace HCES\Http\Controllers;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use HCES\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
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
        $positions = Position::orderBy('rank')->orderBy('name')->paginate(100);
        return view('pages.positions.index')->with('positions', $positions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $position = Position::where('rank', '>', 0)->orderBy('rank', 'desc')->first();
        $highest_rank = !is_null($position) ? $position->rank : 1;
        return view('pages.positions.create')->with('highest_rank', $highest_rank);
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
                'rank' => 'required',
                'name' => 'required',
                'description' => 'required',
                'employment_status' => 'required',
                'rate' => 'required',
                'rate_type' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect(route('positions.create'))
                    ->withErrors($validator)
                    ->withInput();
            }
            $data = $request->all();
            $data['name'] = strtolower($data['name']);
            $existing_position = !is_null(Position::where('name', $data['name'])->where('employment_status', $data['employment_status'])->first());
            if ($existing_position) {
                return redirect(route('positions.create'))
                    ->with('status_error', 'Position already exist!');
            }
            $position = new Position($data);
            $position->save();
            DB::commit();
            return redirect(route('positions.index'))
                ->with('status_success', 'Position created!');
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
        $position = Position::find($id);
        $position_data = Position::where('rank', '>', 0)->orderBy('rank', 'desc')->first();
        $highest_rank = !is_null($position_data) ? $position_data->rank : 1;
        return view('pages.positions.edit')->with(['position' => $position, 'highest_rank' => $highest_rank]);
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
                'rank' => 'required',
                'name' => 'required',
                'description' => 'required',
                'employment_status' => 'required',
                'rate' => 'required',
                'rate_type' => 'required'
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = $request->all();
            $data['name'] = strtolower($data['name']);
            $existing_position = !is_null(Position::where('id', '!=', $id)->where('name', $data['name'])->where('employment_status', $data['employment_status'])->first());
            if ($existing_position) {
                return back()
                    ->with('status_error', 'Position already exist!');
            }
            $position = Position::find($id);
            $position->fill($data);
            $position->save();
            DB::commit();
            return redirect(route('positions.index'))
                ->with('status_success', 'Position updated!');
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
            $position = Position::with('employees')->find($id);
            foreach ($position->employees as $employee) {
                $employee->position_id = null;
                $employee->save();
            }
            $position->delete();
            DB::commit();
            return redirect(route('positions.index'))
                ->with('status_success', 'Position deleted!');
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            DB::rollBack();
            return back()->with('status_error', 'Delete failed: ' . $exception->getMessage());
        }
    }
}
