<?php

namespace HCES\Http\Controllers;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use HCES\Benefits;
use HCES\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BenefitsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permissions:sysvar.management');
    }

    public function index()
    {
        $benefits = Benefits::paginate(100);
        return view('pages.benefits.index')->with([
            'benefits' => $benefits
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.benefits.create');
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
            ]);
            if ($validator->fails()) {
                return redirect(route('benefits.create'))
                    ->withErrors($validator)
                    ->withInput();
            }
            $data = $request->all();
            $benefit = new Benefits($data);
            $benefit->save();
            DB::commit();
            return redirect(route('benefits.index'))
                ->with('status_success', 'Benefit created!');
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
        $benefit = Benefits::find($id);
        return view('pages.benefits.edit')->with('benefit', $benefit);
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
            ]);
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $data = $request->all();
            $benefit = Benefits::find($id);
            $benefit->fill($data);
            $benefit->save();
            DB::commit();
            return redirect(route('benefits.index'))
                ->with('status_success', 'Benefit updated!');
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
            $benefit = Benefits::find($id);
            $benefit->delete();
            DB::commit();
            return redirect(route('benefits.index'))
                ->with('status_success', 'Benefit deleted!');
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            DB::rollBack();
            return back()->with('status_error', 'Delete failed: ' . $exception->getMessage());
        }
    }
}
