<?php

namespace App\Http\Controllers;

use App\Permission;
use App\User;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permissions:user.management');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('pages.user.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('pages.user.create')->with('permissions', $permissions);
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
                'email' => 'required',
                'password' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'permissions' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect(route('user.create'))
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = $request->all();
            $user = new User($data);
            $user->save();
            $permissions = Permission::whereIn('id', $data['permissions'])->get();
            $user->permissions()->attach($permissions);
            DB::commit();
            return redirect(route('user.index'))
                ->with('status_success', 'User created!');
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
        $user = User::with('permissions')->where('id', $id)->first();
        $permissions = Permission::all();
        return view('pages.user.edit')->with(['user' => $user, 'permissions' => $permissions]);
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
                'email' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'permissions' => 'required',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = $request->all();
            if (is_null($data['password'])) {
                unset($data['password']);
            }
            $user = User::find($id);
            $user->fill($data);
            $user->save();
            $user->permissions()->detach();
            $user->permissions()->attach(Permission::whereIn('id', $data['permissions'])->get());
            DB::commit();
            return redirect(route('user.index'))
                ->with('status_success', 'User updated!');
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
            $user = User::find($id);
            $user->delete();
            DB::commit();
            return redirect(route('user.index'))
                ->with('status_success', 'User deleted!');
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            DB::rollBack();
            return back()->with('status_error', 'Delete failed: ' . $exception->getMessage());
        }

    }
}
