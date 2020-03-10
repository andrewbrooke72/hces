<?php

namespace HCES\Http\Controllers;

use HCES\PasswordReset;
use HCES\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use League\Flysystem\Exception;
use Snowfire\Beautymail\Beautymail;

class PasswordResetController extends Controller
{
    protected $token_count = 100;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.password.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['token'] = $data['_token'];
            $user = User::select('email', 'id', 'first_name', 'last_name')->where('email', $data['email'])->first();
            if (is_null($user)) {
                return back()->with('status_error', $data['email'] . ' does not exist!');
            }
            $data['created_at'] = Carbon::now();
            $password_reset = new PasswordReset($data);
            $password_reset->save();
            $beautymail = app()->make(Beautymail::class);
            $link = route('reset.show', ['id' => $data['token']]);
            $beautymail->send('emails.welcome', ["link" => $link, "user" => $user], function ($message) use ($user) {
                $message
                    ->from('noreply@irisglobal.co.uk')
                    ->to($user->email, $user->first_name)
                    ->subject('Arsenal Reset Password Notification');
            });
            DB::commit();
            return back()->with('status_success', 'Password reset sent to email');
        } catch (Exception $exception) {
            DB::rollBack();
            return back()->with('status_error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd($id);
    }

    /**
     * Resets the password.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        //
    }
}
