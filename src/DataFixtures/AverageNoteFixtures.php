<?php

namespace App\DataFixtures;

use App\Entity\Student;
use App\Entity\SubjectNote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AverageNoteFixtures extends Fixture
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
            ->setNote(17)
            ->setStudent($student1)
        ;
        $manager->persist($subjectNote);

        $subjectNote = (new SubjectNote())
            ->setSubject('Français')
            ->setNote(2.5)
            ->setStudent($student1)
        ;
        $manager->persist($subjectNote);

        $student2 = (new Student())
            ->setLastName('Jean')
            ->setFirstName('Galaxie')
            ->setBirthDate(new \DateTimeImmutable('1990-11-27'))
        ;
        $manager->persist($student2);

        $subjectNote = (new SubjectNote())
            ->setSubject('Histoire')
            ->setNote(12.5)
            ->setStudent($student2)
        ;
        $manager->persist($subjectNote);

        $subjectNote = (new SubjectNote())
            ->setSubject('Français')
            ->setNote(14)
            ->setStudent($student2)
        ;
        $manager->persist($subjectNote);

        $manager->flush();
    }
}
