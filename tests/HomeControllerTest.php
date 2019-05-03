<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Kernel;
use App\Controller\HomeController;
// Load the autoloader class so that the controller can find everything it needs
//$loader = require 'app/vendor/autoload.php';
//require 'vendor/autoload.php';



class HomeControllerTest extends TestCase
{

    public function testIndex()
    {
        // Create a new Symfony kernel instance
        $kernel = new Kernel('prod', false);
        //$kernel = new \AppKernel('dev', true);
        // Boot the kernel
        $kernel->boot();
        // Get the kernel container
        $container = $kernel->getContainer();
        // Services can be retrieved like so if you need to
        //$service = $container->get('name.of.registered.service');

        // Create a new instance of your controller
        $controller = new HomeController;
        // You MUST set the container for it to work properly
        $controller->setContainer($container);

        $this->assertEquals(200, $controller->index()->getStatusCode());
    }
}
