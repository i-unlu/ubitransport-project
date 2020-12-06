<?php

namespace Tests\UnitTest\App\Entity;

use App\Entity\Student;
use PHPUnit\Framework\TestCase;

class StudentTest extends TestCase
{
    public function testValidStudent(): void
    {
        $student = (new Student())
            ->setLastName('LastName')
            ->setFirstName('FirstName')
            ->setBirthDate(new \DateTime('1981-03-22'))
        ;

        $lastName = $student->getLastName();
        $firstName = $student->getFirstName();
        $birthDate = $student->getBirthDate();

        $this->assertNotEmpty($firstName);
        $this->assertNotEmpty($lastName);
        $this->assertSame('LastName', $lastName);
        $this->assertSame('FirstName', $firstName);
        $this->assertSame('1981-03-22', $birthDate->format('Y-m-d'));
    }
}
