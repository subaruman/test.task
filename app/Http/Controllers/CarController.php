<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as HttpResponse;
use OpenApi\Annotations\OpenApi as OA;

class CarController extends Controller
{
    /**
     * @OA\Get(
     *     path="/cars?page={page}",
     *     summary="Get list of all cars",
     *     tags={"Car"},
     *     @OA\Parameter(
     *         name="page",
     *         in="path",
     *         description="Page number",
     *         example=1,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Schema(
     *       schema="pagination",
     *       @OA\Property(
     *       property="page",
     *       type="integer",
     *       minimum=1
     *       ),
     *       ),
     * ),
     *
     */
    public function index(): JsonResource
    {
        return CarResource::collection(Car::paginate(10));
    }

    /**
     * @OA\Post(
     *     path="/cars",
     *     summary="Create new car",
     *     tags={"Car"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CarRequest",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\Schema(ref="#/definitions/Car"),
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error",
     *     )
     * )
     */
    public function store(CarRequest $request): JsonResource
    {
        return new CarResource(Car::create($request->validated()));
    }

    /**
     * @OA\Get(
     *     path="/cars/{id}/edit",
     *     summary="Get car data for edit",
     *     tags={"Car"},
     *     description="Get car by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Car id",
     *         required=true,
     *         example=1,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\Schema(ref="#/definitions/Car"),
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Car is not found",
     *     )
     * )
     */
    public function edit(Car $car): JsonResource
    {
        return new CarResource($car);
    }

    /**
     * @OA\Patch(
     *     path="/cars/{id}",
     *     summary="Update car data",
     *     tags={"Car"},
     *     description="Update car by id",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CarRequest",
     *             )
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Car id",
     *         required=true,
     *         example=1,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\Schema(ref="#/definitions/Car"),
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Car is not found",
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error",
     *     ),
     * )
     */
    public function update(Car $car, CarRequest $request): JsonResource
    {
        $car->update($request->validated());

        return new CarResource($car);
    }

    /**
     * @OA\Delete(
     *     path="/cars/{id}",
     *     summary="Delete car",
     *     tags={"Car"},
     *     description="Delete car by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Car id",
     *         required=true,
     *         example=1,
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation",
     *         @OA\Schema(ref="#/definitions/Car"),
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Car is not found",
     *     )
     * )
     */
    public function destroy(Car $car): Response
    {
        $car->delete();

        return HttpResponse::noContent();
    }
}
