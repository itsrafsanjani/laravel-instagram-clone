<?php

namespace Tests\Feature;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Tests\TestCase;

class ThrottleLoginsTest extends TestCase
{
    /**
     * @test
     * @dataProvider emailProvider
     */
    public function it_can_generate_throttle_key(string $email, string $expectedEmail): void
    {
        $throttle = $this->getMockForTrait(ThrottlesLogins::class, [], '', true, true, true, ['username']);
        $throttle->method('username')->willReturn('email');
        $reflection = new \ReflectionClass($throttle);
        $method = $reflection->getMethod('throttleKey');
        $method->setAccessible(true);

        $request = $this->mock(Request::class);
        $request->expects('input')->with('email')->andReturn($email);
        $request->expects('ip')->andReturn('192.168.0.1');

        $this->assertSame($expectedEmail.'|192.168.0.1', $method->invoke($throttle, $request));
    }

    public static function emailProvider(): array
    {
        return [
            'lowercase special characters' => ['ⓣⓔⓢⓣ@ⓛⓐⓡⓐⓥⓔⓛ.ⓒⓞⓜ', 'test@laravel.com'],
            'uppercase special characters' => ['ⓉⒺⓈⓉ@ⓁⒶⓇⒶⓋⒺⓁ.ⒸⓄⓂ', 'test@laravel.com'],
            'special character numbers' => ['test⑩⓸③@laravel.com', 'test1043@laravel.com'],
            'default email' => ['test@laravel.com', 'test@laravel.com'],
        ];
    }
}
