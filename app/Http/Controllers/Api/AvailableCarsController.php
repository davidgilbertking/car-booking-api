<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Car;
class AvailableCarsController extends Controller

{
    public function index(Request $request)
    {
        $request->validate([
                               'start_time' => 'required|date',
                               'end_time' => 'required|date|after:start_time',
                               'model_id' => 'nullable|integer|exists:car_models,id',
                               'category_id' => 'nullable|integer|exists:comfort_categories,id',
                           ]);

        $positionId = auth()->user()->position_id;

        // получаем список категорий, доступных этой должности
        $allowedCategoryIds = DB::table('position_comfort_category')
                                ->where('position_id', $positionId)
                                ->pluck('comfort_category_id');

        // получаем id моделей, соответствующих этим категориям
        $allowedModelIds = DB::table('car_models')
                             ->whereIn('comfort_category_id', $allowedCategoryIds)
                             ->pluck('id');

        // фильтр по модели, если передан
        if ($request->filled('model_id')) {
            $allowedModelIds = $allowedModelIds->intersect([$request->model_id]);
        }

        // получаем id машин, которые заняты в это время
        $busyCarIds = DB::table('trips')
                        ->where(function ($q) use ($request) {
                            $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                              ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                              ->orWhere(function ($q) use ($request) {
                                  $q->where('start_time', '<=', $request->start_time)
                                    ->where('end_time', '>=', $request->end_time);
                              });
                        })
                        ->pluck('car_id');

        // финальный выбор машин
        $cars = Car::with('carModel', 'driver')
                   ->whereIn('car_model_id', $allowedModelIds)
                   ->whereNotIn('id', $busyCarIds)
                   ->when($request->filled('category_id'), function ($q) use ($request) {
                       $q->whereHas('carModel', function ($q) use ($request) {
                           $q->where('comfort_category_id', $request->category_id);
                       });
                   })
                   ->get();

        return response()->json($cars);
    }
}
