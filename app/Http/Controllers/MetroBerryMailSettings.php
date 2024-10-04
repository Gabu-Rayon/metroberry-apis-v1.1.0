<?php

// app/Http/Controllers/MetroBerryMailSettings.php
namespace App\Http\Controllers;

use App\Models\MailSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class MetroBerryMailSettings extends Controller
{
    public function mailSetting()
    {
        return view('settings.mail');
    }

    public function mailSettingUpdate(Request $request)
    {
        Log::info('Data request from mail setting Form: ');
        Log::info($request->all());
        // Validate the request
        $data = $request->all();

        $validator = Validator::make($data, [
            'mail_mailer' => 'required|string',
            'mail_host' => 'required|string',
            'mail_port' => 'required|integer',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => 'required|string',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            Log::info('VALIDATION ERROR');
            Log::info($validator->errors());
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        // Update the settings in the database
        MailSetting::updateOrCreate(
            ['id' => 1], // Assuming single record, adjust as needed
            $request->only([
                'mail_mailer',
                'mail_host',
                'mail_port',
                'mail_username',
                'mail_password',
                'mail_encryption',
                'mail_from_address',
                'mail_from_name'
            ])
        );

        // Update the .env file
        $this->updateEnvFile($request);

        // Refresh config
        config([
            'mail.mailers.smtp' => [
                'transport' => 'smtp',
                'url' => env('MAIL_URL'),
                'host' => env('MAIL_HOST'),
                'port' => env('MAIL_PORT'),
                'encryption' => env('MAIL_ENCRYPTION'),
                'username' => env('MAIL_USERNAME'),
                'password' => env('MAIL_PASSWORD'),
                'timeout' => null,
                'auth_mode' => null,
                'stream' => [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                ],
                'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url(env('APP_URL', 'http://localhost'), PHP_URL_HOST)),
            ]
        ]);

        return redirect()->back()->with('success', 'Mail settings updated successfully.');
    }

    private function updateEnvFile(Request $request)
    {
        $envFile = base_path('.env');

        $replace = [
            'MAIL_MAILER' => $request->input('mail_mailer'),
            'MAIL_HOST' => $request->input('mail_host'),
            'MAIL_PORT' => $request->input('mail_port'),
            'MAIL_USERNAME' => $request->input('mail_username'),
            'MAIL_PASSWORD' => $request->input('mail_password'),
            'MAIL_ENCRYPTION' => $request->input('mail_encryption'),
            'MAIL_FROM_ADDRESS' => $request->input('mail_from_address'),
            'MAIL_FROM_NAME' => $request->input('mail_from_name'),
        ];

        foreach ($replace as $key => $value) {
            // Add quotes only for MAIL_FROM_NAME
            if ($key === 'MAIL_FROM_NAME') {
                $value = '"' . $value . '"';
            }

            if ($value !== null) {
                $this->replaceEnvValue($envFile, $key, $value);
            }
        }
    }

    private function replaceEnvValue($filePath, $key, $value)
    {
        $contents = File::get($filePath);
        $pattern = "/^{$key}=.*$/m";
        $replacement = "{$key}={$value}";
        if (preg_match($pattern, $contents)) {
            $contents = preg_replace($pattern, $replacement, $contents);
        } else {
            $contents .= PHP_EOL . $replacement;
        }
        File::put($filePath, $contents);
    }

}