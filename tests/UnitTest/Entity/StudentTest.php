<?php

namespace Tests\App\Entity;

use App\Entity\Student;
use PHPUnit\Framework\TestCase;

class StudentTest extends TestCase
{
    public function testValidStudent(): void
    {
        $student = (new Student())
            ->setLastName('LastName')
            ->setFirstName('FirstName')
        ;

        $lastName = $student->getLastName();
        $firstName = $student->getFirstName();

        $this->assertNotEmpty($firstName);
        $this->assertNotEmpty($lastName);
        $this->assertSame('LastName', $lastName);
        $this->assertSame('FirstName', $firstName);
    }
}
