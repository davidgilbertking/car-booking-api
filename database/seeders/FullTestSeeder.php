<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarModel;
use App\Models\ComfortCategory;
use App\Models\Driver;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FullTestSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Car::truncate();
        CarModel::truncate();
        ComfortCategory::truncate();
        Driver::truncate();
        Position::truncate();
        User::truncate();
        DB::table('position_comfort_category')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Позиции
        $manager = Position::create(['name' => 'Менеджер']);
        $director = Position::create(['name' => 'Директор']);

        // Категории
        $first = ComfortCategory::create(['name' => 'Первая', 'level' => 1]);
        $second = ComfortCategory::create(['name' => 'Вторая', 'level' => 2]);
        $third = ComfortCategory::create(['name' => 'Третья', 'level' => 3]);


        // Связь должностей и категорий
        $manager->comfortCategories()->attach([$first->id, $second->id]);
        $director->comfortCategories()->attach([$first->id, $second->id, $third->id]);

        // Модели
        $camry = CarModel::create(['name' => 'Toyota Camry', 'comfort_category_id' => $second->id]);
        $granta = CarModel::create(['name' => 'Lada Granta', 'comfort_category_id' => $first->id]);
        $merc = CarModel::create(['name' => 'Mercedes E200', 'comfort_category_id' => $third->id]);

        // Водители
        $driver1 = Driver::create(['name' => 'Творимир Ермилович Королев', 'phone' => '+71410757029']);
        $driver2 = Driver::create(['name' => 'Куприян Эдуардович Родионов', 'phone' => '+7 (073) 856-9534']);

        // Машины
        Car::create(['license_plate' => 'A111AA', 'car_model_id' => $camry->id, 'driver_id' => $driver1->id]);
        Car::create(['license_plate' => 'B222BB', 'car_model_id' => $granta->id, 'driver_id' => $driver2->id]);
        Car::create(['license_plate' => 'C333CC', 'car_model_id' => $merc->id, 'driver_id' => $driver1->id]);
        Car::create(['license_plate' => 'D444DD', 'car_model_id' => $camry->id, 'driver_id' => $driver2->id]);

        // Пользователь
        User::create([
                         'name' => 'Тестовый Пользователь',
                         'email' => 'test@example.com',
                         'password' => Hash::make('password'),
                         'position_id' => $manager->id,
                     ]);
    }
}
