<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DriverImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Generate a random password
        $randomPassword = Str::random(8);

        // Handle avatar upload
        $avatarPath = null;
        if (isset($row['avatar']) && $row['avatar']) {
            $avatarPath = $this->storeFile($row['avatar'], 'uploads/user-avatars');
        }

        // Handle national ID front avatar upload
        $nationalIdFrontAvatarPath = null;
        if (isset($row['national_id_front_avatar']) && $row['national_id_front_avatar']) {
            $nationalIdFrontAvatarPath = $this->storeFile($row['national_id_front_avatar'], 'uploads/front-page-ids');
        }

        // Handle national ID behind avatar upload
        $nationalIdBehindAvatarPath = null;
        if (isset($row['national_id_behind_avatar']) && $row['national_id_behind_avatar']) {
            $nationalIdBehindAvatarPath = $this->storeFile($row['national_id_behind_avatar'], 'uploads/back-page-ids');
        }

        $user = User::updateOrCreate(
            ['email' => $row['email']],
            [
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => Hash::make($randomPassword),
                'phone' => $row['phone'],
                'address' => $row['address'],
                'avatar' => $avatarPath,
                'role' => 'driver',
                'created_by' => Auth::user()->id,
            ]
        );

        $organisationId = null;
        if (Auth::user()->role == 'organisation') {
            $organisationId = Auth::user()->id;
        }

        Driver::updateOrCreate(
            ['user_id' => $user->id],
            [
                'created_by' => Auth::user()->id,
                /***
                 * Organisation ID Handling: The organisation_id is determined based on the
                 *  logged-in user’s role. If the user’s role is organisation, the ID
                 *  of the logged-in user is set as organisation_id. If the user is an admin,
                 *  it remains null.
                 */
                'organisation_id' => $organisationId,
                'vehicle_id' => null,
                'national_id_no' => $row['national_id_no'],
                'national_id_front_avatar' => $nationalIdFrontAvatarPath,
                'national_id_behind_avatar' => $nationalIdBehindAvatarPath,
                'status' => 'inactive',
            ]
        );

        // Optionally, you could send the generated password to the user via email
        // Mail::to($user->email)->send(new NewUserImported($user, $randomPassword));
    }

    private function storeFile($file, $path)
    {
        $fileName = time() . '_' . preg_replace('/\s+/', '_', strtolower($file));
        $filePath = Storage::disk('public')->putFileAs($path, $file, $fileName);
        return $filePath;
    }
}