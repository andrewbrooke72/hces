<?php

namespace HCES\Http\Controllers;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use HCES\TestPaper;
use HCES\TestPaperQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestPaperController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permissions:testpaper.management');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $test_papers = TestPaper::with([
            'questions',
            'questions.choices'
        ])->paginate(10);
        return view('pages.testpapers.index')->with([
            'test_papers' => $test_papers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.testpapers.create');
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
            $test_paper = new TestPaper($data);
            $test_paper->save();
            DB::commit();
            return back()->with('status_success', 'Test Successfully Created');
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
        $test_paper = TestPaper::with([
            'questions',
            'questions.choices'
        ])->where('id', $id)->firstOrFail();
        return view('pages.testpapers.edit')->with([
            'test_paper' => $test_paper
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
        DB::beginTransaction();
        try {
            $test_paper = TestPaper::find($id);
            $test_paper->delete();
            $questions = TestPaperQuestion::with('choices')->where('test_paper_id', $id)->get();
            foreach ($questions as $question) {
                foreach ($question->choices as $choice) {
                    $choice->delete();
                }
                $question->delete();
            }
            DB::commit();
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            DB::rollBack();
            return back()->with('status_error', 'Deletion failed: ' . $exception->getMessage());
        }
    }
}
