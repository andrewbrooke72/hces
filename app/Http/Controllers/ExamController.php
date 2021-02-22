<?php

namespace HCES\Http\Controllers;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use HCES\ExamAttempt;
use HCES\Module;
use HCES\ModuleTestpaper;
use HCES\TestPaper;
use HCES\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $module = Module::with([
            'testpapers',
            'testpapers.questions',
            'testpapers.questions.choices' => function ($query) {
                $query->select('value', 'test_paper_question_id');
            }
        ])->where('is_active', 1)->firstOrFail();
        return view('pages.exams.index')->with([
            'module' => $module
        ]);
    }

    public function loadSlide($id)
    {
        $test_paper = TestPaper::find(decrypt($id));
        $slide = $test_paper->slide_url;
        if (auth()->user()->has_read_slide) {
            return redirect(route('exams.loadexam', ['id' => encrypt($test_paper->id)]));
        }
        return view('pages.exams.slide')->with([
            'slide' => $slide,
            'test_paper_id' => encrypt($test_paper->id)
        ]);
    }

    public function loadExam($id)
    {
        $user = User::find(auth()->user()->id);
        $user->has_read_slide = 1;
        $user->save();
        $test_paper = TestPaper::with([
            'questions',
            'questions.choices' => function ($query) {
                $query->select('value', 'test_paper_question_id', 'id');
            }
        ])->find(decrypt($id));
        $limit = $test_paper->number_of_questions;
        $star_questions = $test_paper->questions->where('is_star', 1);
        $non_star_questions = $test_paper->questions->where('is_star', 0);
        $questions = [];
        if ($star_questions->count()) {
            $to_push = $star_questions->count() >= $limit ? $star_questions->random($limit) : $star_questions->random($star_questions->count());
            array_push($questions, $to_push);
        }
        $limit = $limit - $star_questions->count();
        if ($non_star_questions->count()) {
            $to_push = $non_star_questions->count() >= $limit ? $non_star_questions->random($limit) : $non_star_questions->random($non_star_questions->count());
            array_push($questions, $to_push);
        }
        $star_ids = isset($questions[0]) > 0 ? $questions[0]->pluck('id')->all() : [];
        $non_star_ids = isset($questions[1]) > 0 ? $questions[1]->pluck('id')->all() : [];
        $question_ids = implode(',', $star_ids) . ',' . implode(',', $non_star_ids);
        return view('pages.exams.exam')->with([
            'test_paper' => $test_paper,
            'compiled_questions' => $questions,
            'question_ids' => $question_ids
        ]);
    }

    public function submitExam(Request $request, $id)
    {
        try {
            $data = $request->all();
            $module = Module::where('is_active', 1)->firstOrFail();
            $test_paper = TestPaper::with([
                'questions' => function ($query) use ($data) {
                    $query->whereIn('id', explode(',', $data['qid']));
                },
                'questions.choices'
            ])->find(decrypt($id));
            $module_test_papers = ModuleTestpaper::where('module_id', $module->id)->orderBy('sort')->get();
            $current_test = $module_test_papers->where('test_paper_id', $test_paper->id)->first();
            $next_test = $module_test_papers->where('sort', '>', $current_test->sort)->first();
            $total_points = 0;
            foreach ($test_paper->questions as $question) {
                $total_points += $question->choices->sum('points');
            }
            $score = 0;
            foreach ($data as $key => $value) {
                if (strpos($key, 'answers') !== false) {
                    if (!is_array($value)) {
                        $question_id = str_replace('_answers', '', $key);
                        $answer = $value;
                        $question = $test_paper->questions->where('id', $question_id)->first();
                        $choice = $question->choices->where('id', $answer)->first();
                        $score += !is_null($choice) ? $choice->points : 0;
                    } else {
                        $question_id = str_replace('_answers', '', $key);
                        $question = $test_paper->questions->where('id', $question_id)->first();
                        $total_points_in_multiple = 0;
                        foreach ($value as $answer) {
                            $choice = $question->choices->where('id', $answer)->first();
                            if (!is_null($choice)) {
                                if ($choice->points == 0) {
                                    $score -= $total_points_in_multiple;
                                    break;
                                }
                                $total_points_in_multiple += $choice->points;
                                $score += $choice->points;
                            }
                        }
                    }
                }
            }
            $score_percent = round(($score / $total_points) * 100);
            $status = $score_percent >= $test_paper->passing_score ? 'PASS' : 'FAIL';
            $attempt = new ExamAttempt([
                'user_id' => auth()->user()->id,
                'test_paper_id' => $test_paper->id,
                'score_percent' => $score_percent,
                'score' => $score,
                'total_points' => $total_points,
                'passing_percent' => $test_paper->passing_score,
                'status' => $status
            ]);
            $attempt->save();
            if (is_null($next_test)) {
                $user = User::find(auth()->user()->id);
                $user->exam_passed = 1;
                $user->save();
                return redirect('/')->with('status_success', 'You have passed all the exams. Your answers are now being processed.');
            }
            $next_test_paper = $next_test->test_paper_id;
            $user = User::find(auth()->user()->id);
            $user->has_read_slide = 0;
            $user->save();
            if ($status == 'FAIL') {
                return redirect(route('exams.loadslide', ['id' => encrypt($test_paper->id)]))->with('status_error', 'Sorry you failed that exam. Read the manual and try again.');
            } else {
                return redirect(route('exams.loadslide', ['id' => encrypt($next_test_paper)]))->with('status_success', 'You passed the exam. Off to the next test. Read before you the module before you start.');
            }
        }catch (\Exception $exception){
            Bugsnag::notifyException($exception);
            DB::rollBack();
            return back()->with('status_error', 'Failed: ' . $exception->getMessage());
        }
    }
}
