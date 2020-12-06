<?php

namespace App\Repository;

use App\Entity\Student;
use App\Entity\SubjectNote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SubjectNoteRepository extends ServiceEntityRepository
{
    /**
     * SubjectNoteRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubjectNote::class);
    }

    /**
     * Get average note by student.
     *
     * @param Student $student
     *
     * @return array
     */
    public function getAverageNote(Student $student): array
    {
        $qb = $this->createQueryBuilder('s');

        $average = $qb
            ->select('COALESCE(AVG(s.note), 0.00) AS average')
            ->andWhere('s.student = :student')
            ->setParameter('student', $student)
            ->getQuery()
            ->getScalarResult()
        ;

        return \reset($average);
    }

    /**
     * Get average note for all students.
     *
     * @return array
     */
    public function getAverageNoteForAllStudents(): array
    {
        $qb = $this->createQueryBuilder('s');

        $average = $qb
            ->select('COALESCE(AVG(s.note), 0.00) AS average')
            ->getQuery()
            ->getScalarResult()
        ;

        return \reset($average);
    }
}
