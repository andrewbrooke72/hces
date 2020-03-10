<?php

namespace App\Http\Controllers;

use App\Permission;
use App\SystemSetting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;

class SystemSetupController extends Controller
{
    public function index()
    {
        return view('pages.setup.index');
    }

    public function postInstall(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'organization_name' => 'required',
                'organization_website' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
            ]);
            $data = $request->all();
            $user = new User($data);
            $user->save();
            $permissions = Permission::all();
            $user->permissions()->attach($permissions);
            $system_setting = SystemSetting::first();
            $system_setting->finished_setup = 1;
            $system_setting->fill($data);
            $system_setting->save();
            DB::commit();
            return redirect('/')->with('status_success', 'WELCOME TO ' . env('APP_NAME'));
        } catch (Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
    }
}
