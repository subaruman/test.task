<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as HttpResponse;

class CarController extends Controller
{
    /**
     * List of all cars
     */
    public function index(Car $car): JsonResource
    {
        return CarResource::collection(Car::paginate(10));
    }

    /**
     * Create new car
     */
    public function store(CarRequest $request): JsonResource
    {
        return new CarResource(Car::create($request->validated()));
    }

    /**
     * Get car data for edit
     */
    public function edit(Car $car): JsonResource
    {
        return new CarResource($car);
    }

    /**
     * Update car data
     */
    public function update(Car $car, CarRequest $request): JsonResource
    {
        $car->update($request->validated());

        return new CarResource($car);
    }

    /**
     * Delete car
     */
    public function destroy(Car $car): Response
    {
        $car->delete();

        return HttpResponse::noContent();
    }
}
