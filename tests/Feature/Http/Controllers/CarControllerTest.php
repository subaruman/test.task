<?php

namespace Http\Controllers;

use App\Models\{Car, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_empty_cars_list()
    {
        $response = $this->getJson(route('car.index'));

        $response->assertJsonStructure([
            'data',
            'links',
            'meta',
        ]);

        $response->assertJsonPath('data', []);
    }

    public function test_get_non_empty_cars_list()
    {
        Car::factory()->count(10)->create();
        $response = $this->getJson(route('car.index'));

        $response->assertJsonCount(10, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'brand',
                    'model',
                    'year_issue',
                    'user_id',
                ],
            ],
        ]);
    }

    public function test_create_car()
    {
        $response = $this->postJson(route('car.store'), Car::factory()->make()->getAttributes());

        $response->assertCreated();
    }

    public function test_create_car_with_error_validation()
    {
        $response = $this->postJson(route('car.store'),
            Car::factory()->make([
                'brand' => 'LADA',
                'model' => 11111,
            ])->getAttributes());

        $response->assertInvalid($response->getOriginalContent()['errors']);
    }

    public function test_create_many_cars_with_same_user_id()
    {
        $user = User::factory()->create();
        $response = $this->postJson(route('car.store'), Car::factory()->for($user)->make()->getAttributes());

        $response->assertCreated();
        $carId = $response->getOriginalContent()['id'];

        $response = $this->postJson(route('car.store'), Car::factory()->for($user)->make()->getAttributes());

        $response->assertCreated();
        $this->assertDatabaseHas((new Car())->getTable(), ['user_id' => null]);
    }

    public function test_get_exist_car_on_edit()
    {
        $car = Car::factory()->create();
        $response = $this->getJson(route('car.edit', $car));

        $response->assertOk();
    }

    public function test_update_exist_car()
    {
        $car = Car::factory()->create();
        $car->year_issue = 2007;
        $response = $this->patchJson(route('car.update', $car), $car->getAttributes());

        $response->assertOk();
    }

    public function test_reset_user_id_on_update_car()
    {
        $user = User::factory()->create();
        $cars = Car::factory()->count(3)->for($user)->create();
        $car = $cars->first();
        $car->year_issue = 2007;

        $response = $this->patchJson(route('car.update', $car), $car->getAttributes());

        $response->assertOk();
        $this->assertDatabaseHas((new Car())->getTable(), ['user_id' => null]);
    }

    public function test_delete_car()
    {
        $car = Car::factory()->create();
        $response = $this->deleteJson(route('car.destroy', $car));

        $response->assertNoContent();
    }
}
