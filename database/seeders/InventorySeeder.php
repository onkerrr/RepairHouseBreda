<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\DeviceModel;
use App\Models\Part;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Apple
        $apple = Brand::create([
            'name' => 'Apple',
            'description' => 'Apple Inc. - Premium smartphones en tablets',
            'is_active' => true,
        ]);

        $iphone13 = DeviceModel::create([
            'brand_id' => $apple->id,
            'name' => 'iPhone 13',
            'description' => '6.1-inch display, A15 Bionic chip',
            'is_active' => true,
        ]);

        Part::create(['device_model_id' => $iphone13->id, 'name' => 'Display/Scherm', 'sku' => 'IP13-DISP-001', 'description' => 'OLED Display 6.1"', 'price' => 199.99, 'stock' => 12, 'min_stock' => 5, 'is_active' => true]);
        Part::create(['device_model_id' => $iphone13->id, 'name' => 'Batterij', 'sku' => 'IP13-BATT-001', 'description' => 'Li-ion 3240mAh', 'price' => 49.99, 'stock' => 25, 'min_stock' => 10, 'is_active' => true]);
        Part::create(['device_model_id' => $iphone13->id, 'name' => 'Achterkant/Back Cover', 'sku' => 'IP13-BACK-001', 'description' => 'Glazen achterkant', 'price' => 79.99, 'stock' => 8, 'min_stock' => 5, 'is_active' => true]);
        Part::create(['device_model_id' => $iphone13->id, 'name' => 'Camera Module', 'sku' => 'IP13-CAM-001', 'description' => 'Dual 12MP camera', 'price' => 129.99, 'stock' => 6, 'min_stock' => 3, 'is_active' => true]);
        Part::create(['device_model_id' => $iphone13->id, 'name' => 'Luidspreker', 'sku' => 'IP13-SPKR-001', 'description' => 'Bottom speaker', 'price' => 24.99, 'stock' => 15, 'min_stock' => 8, 'is_active' => true]);

        $iphone14 = DeviceModel::create([
            'brand_id' => $apple->id,
            'name' => 'iPhone 14 Pro',
            'description' => '6.1-inch display, A16 Bionic chip, Dynamic Island',
            'is_active' => true,
        ]);

        Part::create(['device_model_id' => $iphone14->id, 'name' => 'Display/Scherm', 'sku' => 'IP14P-DISP-001', 'description' => 'OLED Display 6.1" ProMotion', 'price' => 299.99, 'stock' => 8, 'min_stock' => 5, 'is_active' => true]);
        Part::create(['device_model_id' => $iphone14->id, 'name' => 'Batterij', 'sku' => 'IP14P-BATT-001', 'description' => 'Li-ion 3200mAh', 'price' => 59.99, 'stock' => 18, 'min_stock' => 10, 'is_active' => true]);
        Part::create(['device_model_id' => $iphone14->id, 'name' => 'Camera Module', 'sku' => 'IP14P-CAM-001', 'description' => 'Triple 48MP camera', 'price' => 199.99, 'stock' => 4, 'min_stock' => 3, 'is_active' => true]);

        // Samsung
        $samsung = Brand::create([
            'name' => 'Samsung',
            'description' => 'Samsung Electronics - Galaxy serie smartphones',
            'is_active' => true,
        ]);

        $s23 = DeviceModel::create([
            'brand_id' => $samsung->id,
            'name' => 'Galaxy S23',
            'description' => '6.1-inch display, Snapdragon 8 Gen 2',
            'is_active' => true,
        ]);

        Part::create(['device_model_id' => $s23->id, 'name' => 'Display/Scherm', 'sku' => 'S23-DISP-001', 'description' => 'AMOLED Display 6.1"', 'price' => 189.99, 'stock' => 10, 'min_stock' => 5, 'is_active' => true]);
        Part::create(['device_model_id' => $s23->id, 'name' => 'Batterij', 'sku' => 'S23-BATT-001', 'description' => 'Li-ion 3900mAh', 'price' => 44.99, 'stock' => 20, 'min_stock' => 10, 'is_active' => true]);
        Part::create(['device_model_id' => $s23->id, 'name' => 'Achterkant/Back Cover', 'sku' => 'S23-BACK-001', 'description' => 'Glazen achterkant Phantom Black', 'price' => 69.99, 'stock' => 12, 'min_stock' => 5, 'is_active' => true]);
        Part::create(['device_model_id' => $s23->id, 'name' => 'USB-C Poort', 'sku' => 'S23-USB-001', 'description' => 'USB-C charging port', 'price' => 19.99, 'stock' => 22, 'min_stock' => 15, 'is_active' => true]);

        $s24Ultra = DeviceModel::create([
            'brand_id' => $samsung->id,
            'name' => 'Galaxy S24 Ultra',
            'description' => '6.8-inch display, Snapdragon 8 Gen 3, S Pen',
            'is_active' => true,
        ]);

        Part::create(['device_model_id' => $s24Ultra->id, 'name' => 'Display/Scherm', 'sku' => 'S24U-DISP-001', 'description' => 'AMOLED Display 6.8" QHD+', 'price' => 349.99, 'stock' => 5, 'min_stock' => 3, 'is_active' => true]);
        Part::create(['device_model_id' => $s24Ultra->id, 'name' => 'Batterij', 'sku' => 'S24U-BATT-001', 'description' => 'Li-ion 5000mAh', 'price' => 69.99, 'stock' => 14, 'min_stock' => 8, 'is_active' => true]);
        Part::create(['device_model_id' => $s24Ultra->id, 'name' => 'S Pen', 'sku' => 'S24U-SPEN-001', 'description' => 'S Pen stylus', 'price' => 39.99, 'stock' => 10, 'min_stock' => 5, 'is_active' => true]);

        // Google
        $google = Brand::create([
            'name' => 'Google',
            'description' => 'Google - Pixel smartphones',
            'is_active' => true,
        ]);

        $pixel8 = DeviceModel::create([
            'brand_id' => $google->id,
            'name' => 'Pixel 8 Pro',
            'description' => '6.7-inch display, Google Tensor G3',
            'is_active' => true,
        ]);

        Part::create(['device_model_id' => $pixel8->id, 'name' => 'Display/Scherm', 'sku' => 'P8P-DISP-001', 'description' => 'OLED Display 6.7" 120Hz', 'price' => 249.99, 'stock' => 6, 'min_stock' => 3, 'is_active' => true]);
        Part::create(['device_model_id' => $pixel8->id, 'name' => 'Batterij', 'sku' => 'P8P-BATT-001', 'description' => 'Li-ion 5050mAh', 'price' => 54.99, 'stock' => 16, 'min_stock' => 8, 'is_active' => true]);
        Part::create(['device_model_id' => $pixel8->id, 'name' => 'Camera Module', 'sku' => 'P8P-CAM-001', 'description' => 'Triple camera 50MP', 'price' => 159.99, 'stock' => 7, 'min_stock' => 4, 'is_active' => true]);

        // OnePlus
        $oneplus = Brand::create([
            'name' => 'OnePlus',
            'description' => 'OnePlus - Flagship killer smartphones',
            'is_active' => true,
        ]);

        $oneplus12 = DeviceModel::create([
            'brand_id' => $oneplus->id,
            'name' => 'OnePlus 12',
            'description' => '6.82-inch display, Snapdragon 8 Gen 3',
            'is_active' => true,
        ]);

        Part::create(['device_model_id' => $oneplus12->id, 'name' => 'Display/Scherm', 'sku' => 'OP12-DISP-001', 'description' => 'AMOLED Display 6.82" 120Hz', 'price' => 179.99, 'stock' => 9, 'min_stock' => 5, 'is_active' => true]);
        Part::create(['device_model_id' => $oneplus12->id, 'name' => 'Batterij', 'sku' => 'OP12-BATT-001', 'description' => 'Li-ion 5400mAh', 'price' => 49.99, 'stock' => 18, 'min_stock' => 10, 'is_active' => true]);

        // Xiaomi
        $xiaomi = Brand::create([
            'name' => 'Xiaomi',
            'description' => 'Xiaomi - Betaalbare high-end smartphones',
            'is_active' => true,
        ]);

        $xiaomi14 = DeviceModel::create([
            'brand_id' => $xiaomi->id,
            'name' => 'Xiaomi 14 Pro',
            'description' => '6.73-inch display, Snapdragon 8 Gen 3',
            'is_active' => true,
        ]);

        Part::create(['device_model_id' => $xiaomi14->id, 'name' => 'Display/Scherm', 'sku' => 'XM14P-DISP-001', 'description' => 'AMOLED Display 6.73"', 'price' => 169.99, 'stock' => 11, 'min_stock' => 6, 'is_active' => true]);
        Part::create(['device_model_id' => $xiaomi14->id, 'name' => 'Batterij', 'sku' => 'XM14P-BATT-001', 'description' => 'Li-ion 4880mAh', 'price' => 42.99, 'stock' => 24, 'min_stock' => 12, 'is_active' => true]);
        Part::create(['device_model_id' => $xiaomi14->id, 'name' => 'Camera Module', 'sku' => 'XM14P-CAM-001', 'description' => 'Leica Triple camera 50MP', 'price' => 149.99, 'stock' => 5, 'min_stock' => 3, 'is_active' => true]);

        $this->command->info('✓ Inventory data seeded successfully!');
        $this->command->info('  - 5 Brands');
        $this->command->info('  - 7 Device Models');
        $this->command->info('  - 27 Parts');
    }
}
