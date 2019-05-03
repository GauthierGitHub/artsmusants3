<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Kernel;// https://stackoverflow.com/questions/49745500/how-to-unit-test-symfony-controllers
use App\Controller\HomeController;

class HomeControllerTest extends TestCase
{
    public function testIndex()
    {
        // Create a new Symfony kernel instance
        $kernel = new Kernel('prod', false);
        // Boot the kernel
        $kernel->boot();
        // Get the kernel container
        $container = $kernel->getContainer();
        // Services can be retrieved like so if you need to
        // $service = $container->get('name.of.registered.service');

        // Create a new instance of your controller
        $controller = new HomeController;
        // You MUST set the container for it to work properly
        $controller->setContainer($container);

        // Verify http status
        $this->assertEquals(200, $controller->index()->getStatusCode());
    }
}
