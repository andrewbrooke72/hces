<?php

namespace HCES\Http\Controllers;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use HCES\QuestionChoice;
use HCES\TestPaper;
use HCES\TestPaperQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestPaperQuestionController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $test_paper_question = new TestPaperQuestion($data);
            $test_paper_question->save();
            if (isset($data['choices'])) {
                foreach ($data['choices'] as $index => $choice) {
                    $choice_data = [
                        'test_paper_question_id' => $test_paper_question->id,
                        'value' => $choice,
                        'points' => $data['points'][$index]
                    ];
                    $test_paper_question_choice = new QuestionChoice($choice_data);
                    $test_paper_question_choice->save();
                }
            }
            DB::commit();
            return back()->with('status_success', 'Question added on exam list.');
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
        DB::beginTransaction();
        try {
            $data = $request->all();
            $question = TestPaperQuestion::find($id);
            $question->fill($data);
            $question->save();
            DB::commit();
            return back()->with('status_success', 'Question updated.');
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            DB::rollBack();
            return back()->with('status_error', 'Creation failed: ' . $exception->getMessage());
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
            $test_paper = TestPaperQuestion::find($id);
            $test_paper->delete();
            QuestionChoice::where('test_paper_question_id', $id)->delete();
            DB::commit();
            return back()->with('status_success', 'DELETED');
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            DB::rollBack();
            return back()->with('status_error', 'Deletion failed: ' . $exception->getMessage());
        }
    }
}
