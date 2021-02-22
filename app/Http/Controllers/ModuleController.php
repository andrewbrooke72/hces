<?php

namespace HCES\Http\Controllers;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use HCES\Module;
use HCES\ModuleTestpaper;
use HCES\TestPaper;
use HCES\TestPaperQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::paginate(10);
        return view('pages.modules.index')->with([
            'modules' => $modules
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.modules.create');
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
            $data = $request->all();
            $module = new Module($data);
            $module->save();
            DB::commit();
            return back()->with('status_success', 'Module Successfully Created');
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
        $module = Module::with([
            'testpapers' => function ($query) {
                $query->orderBy('sort');
            },
            'testpapers.questions'
        ])->find($id);
        $test_papers = TestPaper::whereNotIn('id', $module->testpapers->pluck('id')->all())->get();
        return view('pages.modules.edit')->with([
            'module' => $module,
            'test_papers' => $test_papers
        ]);
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
            $data = $request->all();
            $module_test_papers = ModuleTestpaper::where('module_id', $id)->get();
            $module_test_paper_last = $module_test_papers->last();
            $sort = 1;
            if (!is_null($module_test_paper_last)) {
                $sort += $module_test_paper_last->sort;
            }
            $module_test_paper = new ModuleTestpaper();
            $module_test_paper->test_paper_id = $data['test_paper_id'];
            $module_test_paper->module_id = $id;
            $module_test_paper->sort = $sort;
            $module_test_paper->save();
            DB::commit();
            return back()->with('status_success', 'Test paper added on module');
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            DB::rollBack();
            return back()->with('status_error', 'Failed: ' . $exception->getMessage());
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
            $module = Module::find($id);
            $module->delete();
            DB::commit();
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            DB::rollBack();
            return back()->with('status_error', 'Deletion failed: ' . $exception->getMessage());
        }
    }

    public function resort(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $module_test_papers = ModuleTestpaper::where('module_id', $data['module_id'])->where('test_paper_id', '!=', $data['from'])->orderBy('sort')->get();
            $from = ModuleTestpaper::where('module_id', $data['module_id'])->where('test_paper_id', '=', $data['from'])->firstOrFail();
            $to = $module_test_papers->where('test_paper_id', '=', $data['to'])->first();
            $from->sort = $to->sort;
            $from->save();
            foreach ($module_test_papers->where('sort', '>', $to->sort) as $module_test_paper) {
                $module_test_paper->sort = $module_test_paper->sort + 1;
                $module_test_paper->save();
            }
            $to->sort = $from->sort + 1;
            $to->save();
            DB::commit();
            return back()->with('status_success', 'Resorted');
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            DB::rollBack();
            return back()->with('status_error', 'Failed: ' . $exception->getMessage());
        }
    }

    public function setAsMain(Request $request, $id){
        DB::beginTransaction();
        try {
            $module = Module::find($id);
            $module->is_active = $module->is_active ? 0 : 1;
            $module->save();
            DB::commit();
            return back()->with('status_success', 'Set as main');
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            DB::rollBack();
            return back()->with('status_error', 'Failed: ' . $exception->getMessage());
        }
    }
}
