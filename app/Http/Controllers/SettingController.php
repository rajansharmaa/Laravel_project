<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use anlutro\LaravelSettings\Facade as Setting;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:update-settings');
        $this->middleware('permission:view-activity-log', ['only' => ['activity']]);
    }
    public function index() {
        activity('settings')
            ->causedBy(Auth::user())
            ->log('view');
        $title =  'Settings';
        $roles = Role::pluck('name', 'id');
        return view('settings.edit', compact('roles', 'title'));
    }

    public function update(Request $request) {

        foreach ($request->all() as $key => $value) {
            if ($request->company_logo) {
                Setting::set($key, parse_url($value, PHP_URL_PATH));
            }else{
                Setting::set($key, $value);
            }
        }
        Setting::save();
        activity('settings')
            ->causedBy(Auth::user())
            ->withProperties($request->all())
            ->log('updated');
        flash('Settings updated successfully!')->success();
        return back();

    }
    public function activity(Request $request){
        $title= 'Activity Logs';
        activity('activity')
        ->causedBy(Auth::user())
        ->log('view');
        $activities = Activity::paginate(setting('record_per_page', 15));
        return view('settings.activity', compact('activities', 'title'));
    }
}
