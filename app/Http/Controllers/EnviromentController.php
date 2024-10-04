<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class EnviromentController extends Controller
{
    public function envSetting()
    {
        return view('settings.env');
    }

    public function envSettingUpdate(Request $request)
    {
        Log::info('Data from the environment form creating');
        Log::info($request->all());
        
        $data = $request->all();

        $validator = Validator::make($data, [
            'app_name' => 'required|string|max:255',
            'app_url' => 'required|string|max:255',
            'app_env' => 'nullable|string',
            'app_debug' => 'nullable|string',
            'force_https' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            Log::info('VALIDATION ERROR');
            Log::info($validator->errors());
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        // Handle checkbox values
        $appDebug = $request->input('app_debug') === 'on';
        $forceHttps = $request->input('force_https') === 'on';

        // Update the database with the new settings
        $settings = [
            'site_url' => $request->input('app_url'),
            'name_of_website' => $request->input('app_name'),
            'environment' => $request->input('app_env'),
            'app_debug' => $appDebug,
            'force_https' => $forceHttps,
        ];

        foreach ($settings as $key => $value) {
            Config::set("app.$key", $value);
        }

        // Update the SiteSetting model
        $siteSetting = SiteSetting::first();
        if ($siteSetting) {
            $siteSetting->update($settings);
        } else {
            SiteSetting::create($settings);
        }

        // Prepare data for .env file update
        $envUpdateData = [
            'APP_URL' => $settings['site_url'],
            'APP_NAME' => $settings['name_of_website'],
            'APP_ENV' => $settings['environment'],
            'APP_DEBUG' => $appDebug ? 'true' : 'false',
        ];

        $this->updateEnvFile($envUpdateData);

        // Flash message and redirect
        return redirect()->back()->with('success', 'Site settings updated successfully.');
    }

    protected function updateEnvFile(array $data)
    {
        $envFile = app()->environmentFilePath();
        $str = File::get($envFile);

        foreach ($data as $key => $value) {
            // Add quotes only for APP_NAME
            if ($key === 'APP_NAME') {
                $value = '"' . $value . '"';
            }

            $str = preg_replace("/^$key=.*/m", "$key=$value", $str);
        }

        File::put($envFile, $str);
    }



}