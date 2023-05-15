<?php

namespace Tests\Feature;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class RegistersUsersTest extends TestCase
{
    use RefreshDatabase, RegistersUsers;

    /** @test */
    public function it_can_register_a_user()
    {
        $request = Request::create('/register', 'POST', [
            'name' => 'Taylor Otwell',
            'email' => 'taylor@laravel.com',
            'username' => 'taylor',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
            'gender' => 'male',
        ], [], [], [
            'HTTP_ACCEPT' => 'application/json',
        ]);

        $response = $this->handleRequestUsing($request, function ($request) {
            return $this->register($request);
        })->assertCreated();

        $this->assertDatabaseHas('users', [
            'name' => 'Taylor Otwell',
            'email' => 'taylor@laravel.com',
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email:rfc', 'max:255', 'unique:users'],
            'username' => [
                'required', 'string', 'min:4', 'max:32', 'unique:users',
                'regex:/(^(?:[a-zA-Z\d]+(?:(?:\.|-|_)[a-zA-Z\d])*)+$)/'
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'gender' => ['required', 'in:male,female,others'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data): User
    {
        $user = (new User())->forceFill([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'gender' => $data['gender'],
        ]);

        $user->save();

        return $user;
    }

    /**
     * Handle Request using the following pipeline.
     *
     * @param  Request  $request
     * @param  callable  $callback
     * @return TestResponse
     */
    protected function handleRequestUsing(Request $request, callable $callback): TestResponse
    {
        return new TestResponse(
            (new Pipeline($this->app))
                ->send($request)
                ->through([
                    StartSession::class,
                ])
                ->then($callback)
        );
    }
}
