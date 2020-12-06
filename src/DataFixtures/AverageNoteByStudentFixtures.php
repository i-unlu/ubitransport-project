<?php

namespace App\DataFixtures;

use App\Entity\Student;
use App\Entity\SubjectNote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AverageNoteByStudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $student1 = (new Student())
            ->setLastName('UNLU')
            ->setFirstName('izzetali')
            ->setBirthDate(new \DateTimeImmutable('1981-03-22'))
        ;
        $manager->persist($student1);

        $subjectNote = (new SubjectNote())
            ->setSubject('Histoire')
            ->setNote(17.5)
            ->setStudent($student1)
        ;
        $manager->persist($subjectNote);

        $subjectNote = (new SubjectNote())
            ->setSubject('Français')
            ->setNote(2.5)
            ->setStudent($student1)
        ;
        $manager->persist($subjectNote);

        $manager->flush();
    }
}
