<?php

namespace App\Imports;

use App\Models\VehicleSpeedGovernorCertificate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;

class SpeedGovernorImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip the header row or empty rows
            if (!$row['vehicle_id'] || $row['vehicle_id'] === 'vehicle_id') {
                continue;
            }

            $avatarPath = null;
            if (isset($row['copy']) && $row['copy']) {
                $avatarPath = $this->storeFile($row['copy'], 'uploads/vehicle-speed-governor-copy');
            }

            VehicleSpeedGovernorCertificate::updateOrCreate(
                [
                    'vehicle_id' => $row['vehicle_id'],
                ],
                [
                    'certificate_no' => $row['certificate_no'],
                    'class_no' => $row['class_no'],
                    'type_of_governor' => $row['type_of_governor'],
                    'date_of_installation' => $row['date_of_installation'],
                    'expiry_date' => $row['expiry_date'],
                    'certificate_copy' => $avatarPath,
                    'chasis_no' => $row['chasis_no'],
                    'status' => 'inactive',
                ]
            );
        }
    }

    private function storeFile($file, $path)
    {
        $fileName = time() . '_' . preg_replace('/\s+/', '_', strtolower($file));
        $filePath = Storage::disk('public')->putFileAs($path, $file, $fileName);
        return $filePath;
    }
}
