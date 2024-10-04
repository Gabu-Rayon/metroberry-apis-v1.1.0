<?php
namespace App\Imports;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrganisationImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Generate a random password
        $randomPassword = Str::random(8);

        // Handle avatar upload
        $avatarPath = isset($row['avatar']) ? $this->storeFile($row['avatar'], 'uploads/company-logos') : null;

        // Handle organisation_certificate upload
        $organisationCertificateAvatarPath = isset($row['organisation_certificate']) ?
            $this->storeFile($row['organisation_certificate'], 'uploads/organisation-certificates') : null;

        $user = User::updateOrCreate(
            ['email' => $row['email']],
            [
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => Hash::make($randomPassword),
                'phone' => $row['phone'],
                'address' => $row['address'],
                'avatar' => $avatarPath,
                'role' => 'organisation',
                'created_by' => Auth::user()->id,
            ]
        );

        Organisation::updateOrCreate(
            ['user_id' => $user->id],
            [
                'certificate_of_organisation' => $organisationCertificateAvatarPath,
                'billing_cycle' => null,
                'terms_and_conditions' => null,
                'created_by' => Auth::user()->id,
                'organisation_code' => $row['organisation_code'],
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