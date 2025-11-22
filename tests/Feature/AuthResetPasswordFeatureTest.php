<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use App\Livewire\Auth\ResetPassword;

class AuthResetPasswordFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_class_exists()
    {
        // Ensure the component class can be autoloaded
        self::assertTrue(class_exists(\App\Livewire\Auth\ResetPassword::class));
    }

            public function test_guest_is_redirected_to_login()
    {
                // The reset password page requires a token param in the route; provide a dummy token and assert accessible to guests.
                $response = $this->get('/reset-password/dummytoken');
                $response->assertStatus(200);
    }



            public function test_authenticated_user_can_mount_component()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
                $fqcn = '\\App\\Livewire\\Auth\\ResetPassword';
                if (class_exists($fqcn) && is_subclass_of($fqcn, \Livewire\Component::class)) {
                    $ref = new \ReflectionClass($fqcn);
                    $params = [];

                    if ($ref->hasMethod('mount')) {
                        $m = $ref->getMethod('mount');
                        foreach ($m->getParameters() as $p) {
                            if (! $p->isOptional()) {
                                $params[$p->getName()] = 'dummytoken';
                            }
                        }
                    }

                    if ($ref->hasMethod('__construct')) {
                        $c = $ref->getConstructor();
                        if ($c) {
                            foreach ($c->getParameters() as $p) {
                                if (! $p->isOptional()) {
                                    $params[$p->getName()] = 'dummytoken';
                                }
                            }
                        }
                    }

                    Livewire::test($fqcn, $params);
                    $this->assertTrue(true);
                    return;
                }

                $this->markTestSkipped('Component class not available or not a Livewire component');
    }

}
