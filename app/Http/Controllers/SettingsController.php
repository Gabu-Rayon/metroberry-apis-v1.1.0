<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{

    public function fuelingSetting()
    {
        // Retrieve current fueling settings from the database
        $settings = SiteSetting::first();
        return view('settings.general-settings.fuel-setting', [
            'station_code_prefix' => $settings->station_code_prefix ?? 'MB-FSC-',
            'station_requisition_prefix' => $settings->station_requisition_prefix ?? 'MB-FRSC-',
        ]);
    }
    /**
     * Update the fueling settings.
     */
    public function fuelingSettingUpdate(Request $request)
    {
        // Validate the incoming request
        $data = $request->all();

        Log::info('Data from  form creating');
        Log::info($request->all());

        $validator = Validator::make($data, [
            'station_code_prefix' => 'required|string|max:255',
            'station_requisition_prefix' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            Log::info('VALIDATION ERROR');
            Log::info($validator->errors());
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }


        // Prepare the settings for update
        $settings = [
            'station_code_prefix' => $request->input('station_code_prefix'),
            'station_requisition_prefix' => $request->input('station_requisition_prefix'),
        ];

        // Update or create the settings in the database
        $siteSetting = SiteSetting::first();
        if ($siteSetting) {
            $siteSetting->update($settings);
        } else {
            SiteSetting::create($settings);
        }

        // Flash message and redirect
        return redirect()->back()->with('success', 'Fueling settings updated successfully.');
    }

    public function maintenanceSetting()
    {
        // Retrieve current fueling settings from the database
        $settings = SiteSetting::first();
        return view('settings.general-settings.maintenance-setting', [
            'maintenance_code_prefix' => $settings->maintenance_code_prefix ?? 'MB-MCP-',
            'maintenance_requisition_prefix' => $settings->maintenance_requisition_prefix ?? 'MB-MRCP-',
        ]);
    }

    /**
     * Update the Maintenance settings.
     */
    public function maintenanceSettingUpdate(Request $request)
    {
        // Validate the incoming request
        $data = $request->all();

        Log::info('Data from  form creating');
        Log::info($request->all());

        $validator = Validator::make($data, [
            'maintenance_code_prefix' => 'required|string|max:255',
            'maintenance_requisition_prefix' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            Log::info('VALIDATION ERROR');
            Log::info($validator->errors());
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }


        // Prepare the settings for update
        $settings = [
            'maintenance_code_prefix' => $request->input('maintenance_code_prefix'),
            'maintenance_requisition_prefix' => $request->input('maintenance_requisition_prefix'),
        ];

        // Update or create the settings in the database
        $siteSetting = SiteSetting::first();
        if ($siteSetting) {
            $siteSetting->update($settings);
        } else {
            SiteSetting::create($settings);
        }

        // Flash message and redirect
        return redirect()->back()->with('success', 'Maintenance settings updated successfully.');
    }
    public function generalSetting()
    {
        return view('settings.general-settings.setting');
    }

    public function languageSetting()
    {
        return view('settings.language');
    }

    public function siteSetting()
    {
        // Fetch all site settings from the database
        $settings = [
            'site_url' => config('app.url'),
            'site_name' => config('app.name'),
            'app_description' => config('app.description'),
            'logo_white' => config('site.logo_light'),
            'logo_black' => config('site.logo_black'),
            'site_favicon' => config('site.favicon'),
        ];


        // Pass the settings to the view
        return view('settings.site', compact('settings'));
    }


    public function siteSettingUpdate(Request $request)
    {
        $data = $request->all();

        Log::info('Data from form creating');
        Log::info($request->all());

        $validator = Validator::make($data, [
            'site_url' => 'required|url',
            'site_name' => 'required|string|max:255',
            'app_description' => 'nullable|string',
            'logo_white' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'logo_black' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'site_favicon' => 'nullable|image|mimes:ico,png|max:2048',
        ]);

        if ($validator->fails()) {
            Log::info('VALIDATION ERROR');
            Log::info($validator->errors());
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        // Update the database with the new settings
        $settings = [
            'site_url' => $request->input('site_url'),
            'name_of_website' => $request->input('site_name'),
            'description' => $request->input('app_description'),
            'logo_white' => null, // Set initial value to null for file paths
            'logo_black' => null,
            'site_favicon' => null,
        ];

        // Handle file uploads
        if ($request->hasFile('logo_white')) {
            $logoWhitePath = $request->file('logo_white')->storeAs('', 'logo_white.' . $request->file('logo_white')->getClientOriginalExtension(), 'public');
            // Store the relative path in the settings array
            $settings['logo_white'] = 'logo_white.' . $request->file('logo_white')->getClientOriginalExtension();
            Config::set('site.logo_light', $settings['logo_white']);
            // Move the uploaded file to the public folder directly
            $request->file('logo_white')->move(public_path(), $settings['logo_white']);
        }

        if ($request->hasFile('logo_black')) {
            $logoBlackPath = $request->file('logo_black')->storeAs('', 'logo_black.' . $request->file('logo_black')->getClientOriginalExtension(), 'public');
            // Store the relative path in the settings array
            $settings['logo_black'] = 'logo_black.' . $request->file('logo_black')->getClientOriginalExtension();
            Config::set('site.logo_black', $settings['logo_black']);
            // Move the uploaded file to the public folder directly
            $request->file('logo_black')->move(public_path(), $settings['logo_black']);
        }

        if ($request->hasFile('site_favicon')) {
            $faviconPath = $request->file('site_favicon')->storeAs('', 'favicon.' . $request->file('site_favicon')->getClientOriginalExtension(), 'public');
            // Store the relative path in the settings array
            $settings['site_favicon'] = 'favicon.' . $request->file('site_favicon')->getClientOriginalExtension();
            Config::set('site.favicon', $settings['site_favicon']);
            // Move the uploaded file to the public folder directly
            $request->file('site_favicon')->move(public_path(), $settings['site_favicon']);
        }

        // Update the SiteSetting model
        $siteSetting = SiteSetting::first();
        if ($siteSetting) {
            $siteSetting->update($settings);
        } else {
            SiteSetting::create($settings);
        }

        // Update the .env file if necessary
        $envUpdateData = [
            'APP_URL' => $settings['site_url'],
            'APP_NAME' => "'" . $settings['name_of_website'] . "'",
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
            $str = preg_replace("/^$key=.*/m", "$key=$value", $str);
        }

        File::put($envFile, $str);
    }


}