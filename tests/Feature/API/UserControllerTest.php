<?php

namespace Tests\Feature\API;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;
    private const USER_TABLE = 'users';

    public function setUp (): void {
        parent::setUp();
    }

    public function testRegisterUser () {
        $this->assertDatabaseCount($this::USER_TABLE, 0);

        $data = [
            'email' => 'user@email.com',
            'name' => 'Some One',
            'phone' => '11111111',
            'nickname' => 'some_one',
            'password' => '123123',
        ];

        $this->post('/api/register', $data)->assertOk();

        $this->assertDatabaseCount($this::USER_TABLE, 1);
        $user = User::find(1);
        $this->assertDatabaseHas($this::USER_TABLE, [
            'id' => 1,
            'name' => $data['name'],
            'email' => $data['email'],
            'nickname' => $data['nickname'],
        ]);
        $this->assertTrue(Hash::check($data['password'], $user->password));
    }

    public function testRegisterUserFailsIfRepeatedEmail () {
        $data = [
            'email' => 'user@email.com',
            'name' => 'Some One',
            'phone' => '11111111',
            'nickname' => 'some_one',
            'password' => '123123',
        ];

        $this->post('/api/register', $data);

        $this->post('/api/register', $data)->assertStatus(Response::HTTP_BAD_REQUEST);

        $this->assertDatabaseCount($this::USER_TABLE, 1);
    }
}
