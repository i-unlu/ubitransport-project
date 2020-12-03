<?php

namespace Tests\App\Entity;

use App\Entity\Student;
use App\Entity\SubjectNote;
use PHPUnit\Framework\TestCase;

class SubjectNoteTest extends TestCase
{
    public function testValidSubjectNote(): void
    {
        $student = (new Student())
            ->setLastName('LastName')
            ->setFirstName('FirstName')
        ;
        $subjectNote = (new SubjectNote())
            ->setNote(11.50)
            ->setSubject('Maths')
            ->setStudent($student)
        ;

        $note = $subjectNote->getNote();
        $subject = $subjectNote->getSubject();
        $student = $subjectNote->getStudent();

        $this->assertNotEmpty($note);
        $this->assertNotEmpty($subject);
        $this->assertNotEmpty($student);
        $this->assertSame(11.50, $note);
        $this->assertSame('Maths', $subject);
        $this->assertInstanceOf(Student::class, $student);
    }
}
