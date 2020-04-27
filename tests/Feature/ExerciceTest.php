<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Exercice;
use App\TypesExercice;

class ExerciceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetExercices()
    {
        
        //$type =  factory(TypesExercice::class)->create();
        $exercice = factory(Exercice::class, 5)->create();

        $response = $this->json('GET', '/api/exercice');

        $response->assertStatus(200);
    }
}
