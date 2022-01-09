<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserProfileTest extends TestCase
{
    use WithFaker;

    public function test_create_user_profile()
    {
        $postData = [
            'firstName'       => $this->faker->name,
            'lastName'        => $this->faker->name,
            'email'           => $this->faker->unique()->safeEmail,
            'password'        => bcrypt('123123'),
            'workExperiences' => [
                [
                    'comapnyName'         => $this->faker->company,
                    'role'                => $this->faker->word,
                    'startedAt'           => Carbon::now()->format('d-m-Y'),
                    'endAtCurrentWorking' => true,
                    'endAt'               => null,
                    'description'         => $this->faker->sentence($nbWords = 6, $variableNbWords = true)
                ]
            ],
            'organizations' => [
                [
                    'name'                => $this->faker->company,
                    'associatedAs'        => 'partner',
                    'startedAt'           => Carbon::now()->format('d-m-Y'),
                    'endAtCurrentWorking' => true,
                    'endAt'               => null,
                    'description'         => $this->faker->sentence($nbWords = 6, $variableNbWords = true)
                ]
            ]
        ];

        $this->postJson('/profile/create', $postData)
            ->assertStatus(200);
    }
}
