<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class VehicleManufacturersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Truncate the table before seeding
        DB::table('vehicle_manufacturers')->truncate();

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        $manufacturers = [
            'Toyota', 'Volkswagen', 'Ford', 'Honda', 'Chevrolet', 
            'Nissan', 'Hyundai', 'BMW', 'Mercedes-Benz', 'Kia', 
            'Renault', 'Peugeot', 'Fiat', 'Subaru', 'Mazda', 
            'Mitsubishi', 'Suzuki', 'Tata Motors', 'Land Rover', 'Jaguar',
            'Volvo', 'Mini', 'Porsche', 'Tesla', 'Ferrari', 
            'Lamborghini', 'Bentley', 'Rolls-Royce', 'Aston Martin', 'Bugatti',
            'Maserati', 'McLaren', 'Alfa Romeo', 'Citroën', 'Dacia',
            'Jeep', 'Dodge', 'Ram', 'Chrysler', 'Buick',
            'GMC', 'Cadillac', 'Lincoln', 'Acura', 'Infiniti',
            'Lexus', 'Genesis', 'Haval', 'Great Wall', 'Chery',
            'BYD', 'Geely', 'MG', 'Roewe', 'Proton',
            'Perodua', 'Saab', 'Skoda', 'Seat', 'Smart',
            'Opel', 'Vauxhall', 'Isuzu', 'Foton', 'Mahindra',
            'Holden', 'SsangYong', 'Daewoo', 'Zotye', 'Baojun',
            'Lifan', 'JAC Motors', 'Tatra', 'UAZ', 'GAZ',
            'Maruti Suzuki', 'Hindustan Motors', 'Premier', 'Ashok Leyland', 'Force Motors'
        ];

        foreach ($manufacturers as $manufacturer) {
            DB::table('vehicle_manufacturers')->insert([
                'name' => $manufacturer,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}