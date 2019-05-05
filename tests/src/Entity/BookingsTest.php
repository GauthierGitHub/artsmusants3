<?php

namespace App\Tests\App\Entity;

use App\Entity\Bookings;
use PHPUnit\Framework\TestCase;

class BookingsTest extends TestCase
{
    public function testSetters()
    {
        // todo
        $this->assertTrue(true);
    }

    public function testFailure()
    {
        // test presence of properties
        $this->assertClassHasAttribute('id', Bookings::class);
        $this->assertClassHasAttribute('date', Bookings::class);
        $this->assertClassHasAttribute('startDate', Bookings::class);
        $this->assertClassHasAttribute('endDate', Bookings::class);
        $this->assertClassHasAttribute('canceled', Bookings::class);
        $this->assertClassHasAttribute('customer', Bookings::class);
        $this->assertClassHasAttribute('painting', Bookings::class);
    }
}
