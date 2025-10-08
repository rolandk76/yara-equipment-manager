<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Equipment;
use App\Models\MaintenanceLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        // Create Categories
        $categories = [
            [
                'name' => 'Werkzeuge',
                'slug' => 'werkzeuge',
                'description' => 'Handwerkzeuge und Elektrowerkzeuge',
                'icon' => '🔨',
                'color' => '#ff8228',
                'sort_order' => 1,
            ],
            [
                'name' => 'Fahrzeuge',
                'slug' => 'fahrzeuge',
                'description' => 'Firmenfahrzeuge und Transportmittel',
                'icon' => '🚗',
                'color' => '#2777b8',
                'sort_order' => 2,
            ],
            [
                'name' => 'IT-Equipment',
                'slug' => 'it-equipment',
                'description' => 'Computer, Laptops, Monitore',
                'icon' => '💻',
                'color' => '#63b6e6',
                'sort_order' => 3,
            ],
            [
                'name' => 'Büroausstattung',
                'slug' => 'bueroausstattung',
                'description' => 'Möbel, Drucker, Büromaterial',
                'icon' => '🖨️',
                'color' => '#507a07',
                'sort_order' => 4,
            ],
            [
                'name' => 'Messgeräte',
                'slug' => 'messgeraete',
                'description' => 'Mess- und Prüfgeräte',
                'icon' => '📏',
                'color' => '#c2cc23',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Get admin user from shared database
        $admin = User::on('shared')->where('email', 'admin@yara.com')->first();

        // Create Equipment
        $werkzeuge = Category::where('slug', 'werkzeuge')->first();
        $fahrzeuge = Category::where('slug', 'fahrzeuge')->first();
        $it = Category::where('slug', 'it-equipment')->first();
        $buero = Category::where('slug', 'bueroausstattung')->first();
        $mess = Category::where('slug', 'messgeraete')->first();

        $equipment = [
            // Werkzeuge
            [
                'category_id' => $werkzeuge->id,
                'name' => 'Bohrmaschine Bosch Professional',
                'equipment_number' => 'WZ-001',
                'description' => 'Professionelle Schlagbohrmaschine',
                'manufacturer' => 'Bosch',
                'model' => 'GSB 13 RE',
                'serial_number' => 'BSH-2023-001',
                'purchase_date' => '2023-01-15',
                'purchase_price' => 189.99,
                'status' => 'available',
                'location' => 'Werkstatt A',
                'maintenance_interval_days' => 180,
                'next_maintenance_date' => now()->addDays(45),
            ],
            [
                'category_id' => $werkzeuge->id,
                'name' => 'Akkuschrauber Makita',
                'equipment_number' => 'WZ-002',
                'description' => '18V Akkuschrauber mit 2 Akkus',
                'manufacturer' => 'Makita',
                'model' => 'DDF482',
                'serial_number' => 'MAK-2023-042',
                'purchase_date' => '2023-03-20',
                'purchase_price' => 249.00,
                'status' => 'in_use',
                'location' => 'Werkstatt B',
                'assigned_to' => $admin?->id,
                'maintenance_interval_days' => 365,
                'next_maintenance_date' => now()->addDays(120),
            ],
            
            // Fahrzeuge
            [
                'category_id' => $fahrzeuge->id,
                'name' => 'VW Transporter',
                'equipment_number' => 'FZ-001',
                'description' => 'Firmenwagen für Transporte',
                'manufacturer' => 'Volkswagen',
                'model' => 'Transporter T6.1',
                'serial_number' => 'WVW-ZZZ-7HZ-123456',
                'purchase_date' => '2022-06-01',
                'purchase_price' => 45000.00,
                'status' => 'available',
                'location' => 'Parkplatz 1',
                'maintenance_interval_days' => 90,
                'next_maintenance_date' => now()->addDays(15),
                'specifications' => [
                    'kennzeichen' => 'Y-AB 1234',
                    'km_stand' => '45000',
                    'kraftstoff' => 'Diesel',
                ],
            ],
            [
                'category_id' => $fahrzeuge->id,
                'name' => 'Ford Transit',
                'equipment_number' => 'FZ-002',
                'description' => 'Lieferwagen',
                'manufacturer' => 'Ford',
                'model' => 'Transit Custom',
                'serial_number' => 'FRD-2022-789',
                'purchase_date' => '2022-09-15',
                'purchase_price' => 38000.00,
                'status' => 'maintenance',
                'location' => 'Werkstatt',
                'maintenance_interval_days' => 90,
                'next_maintenance_date' => now()->subDays(5),
                'specifications' => [
                    'kennzeichen' => 'Y-CD 5678',
                    'km_stand' => '62000',
                    'kraftstoff' => 'Diesel',
                ],
            ],
            
            // IT-Equipment
            [
                'category_id' => $it->id,
                'name' => 'Dell Latitude Laptop',
                'equipment_number' => 'IT-001',
                'description' => 'Business Laptop',
                'manufacturer' => 'Dell',
                'model' => 'Latitude 5420',
                'serial_number' => 'DELL-2023-LAT-001',
                'purchase_date' => '2023-02-10',
                'purchase_price' => 1299.00,
                'status' => 'in_use',
                'location' => 'Büro 201',
                'assigned_to' => $admin?->id,
                'maintenance_interval_days' => 365,
                'next_maintenance_date' => now()->addDays(200),
                'specifications' => [
                    'cpu' => 'Intel Core i7',
                    'ram' => '16GB',
                    'storage' => '512GB SSD',
                ],
            ],
            [
                'category_id' => $it->id,
                'name' => 'HP Monitor 27"',
                'equipment_number' => 'IT-002',
                'description' => '27 Zoll 4K Monitor',
                'manufacturer' => 'HP',
                'model' => 'E27 G4',
                'serial_number' => 'HP-2023-MON-042',
                'purchase_date' => '2023-04-05',
                'purchase_price' => 399.00,
                'status' => 'available',
                'location' => 'Lager IT',
                'maintenance_interval_days' => 730,
                'next_maintenance_date' => now()->addDays(500),
            ],
            
            // Büroausstattung
            [
                'category_id' => $buero->id,
                'name' => 'HP LaserJet Pro',
                'equipment_number' => 'BU-001',
                'description' => 'Netzwerkdrucker S/W',
                'manufacturer' => 'HP',
                'model' => 'LaserJet Pro M404dn',
                'serial_number' => 'HP-2022-LJ-123',
                'purchase_date' => '2022-11-20',
                'purchase_price' => 289.00,
                'status' => 'available',
                'location' => 'Büro Etage 2',
                'maintenance_interval_days' => 180,
                'next_maintenance_date' => now()->addDays(90),
            ],
            
            // Messgeräte
            [
                'category_id' => $mess->id,
                'name' => 'Digitales Multimeter',
                'equipment_number' => 'MG-001',
                'description' => 'Präzisions-Multimeter',
                'manufacturer' => 'Fluke',
                'model' => '87V',
                'serial_number' => 'FLK-2023-001',
                'purchase_date' => '2023-05-10',
                'purchase_price' => 449.00,
                'status' => 'available',
                'location' => 'Labor',
                'maintenance_interval_days' => 365,
                'next_maintenance_date' => now()->addDays(280),
            ],
        ];

        foreach ($equipment as $equipmentData) {
            Equipment::create($equipmentData);
        }

        // Create some maintenance logs
        if ($admin) {
            $bohrmaschine = Equipment::where('equipment_number', 'WZ-001')->first();
            if ($bohrmaschine) {
                MaintenanceLog::create([
                    'equipment_id' => $bohrmaschine->id,
                    'performed_by' => $admin->id,
                    'type' => 'routine',
                    'maintenance_date' => now()->subDays(90),
                    'description' => 'Routinewartung durchgeführt',
                    'cost' => 25.00,
                    'duration_minutes' => 30,
                    'next_maintenance_date' => now()->addDays(90),
                    'notes' => 'Alle Funktionen geprüft, Kohlebürsten OK',
                ]);
            }

            $transporter = Equipment::where('equipment_number', 'FZ-001')->first();
            if ($transporter) {
                MaintenanceLog::create([
                    'equipment_id' => $transporter->id,
                    'performed_by' => $admin->id,
                    'type' => 'inspection',
                    'maintenance_date' => now()->subDays(60),
                    'description' => 'Hauptuntersuchung',
                    'cost' => 150.00,
                    'duration_minutes' => 120,
                    'next_maintenance_date' => now()->addDays(30),
                    'notes' => 'TÜV bestanden, nächste HU in 2 Jahren',
                ]);
            }
        }

        $this->command->info('✅ Equipment Seeder erfolgreich ausgeführt!');
        $this->command->info('   - 5 Kategorien erstellt');
        $this->command->info('   - 9 Equipment-Einträge erstellt');
        $this->command->info('   - 2 Wartungsprotokolle erstellt');
    }
}

