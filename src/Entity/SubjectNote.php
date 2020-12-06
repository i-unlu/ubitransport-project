<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Student.
 *
 * @ORM\Table(name="subject_note")
 * @ORM\Entity(repositoryClass="App\Repository\SubjectNoteRepository")
 *
 * @OA\Schema(
 *     schema="SubjectNote",
 *     type="object",
 *     description="Subject note model",
 *     required={"subject", "note", "student"}
 * )
 *
 * @ExclusionPolicy("all")
 */
class SubjectNote
{
    use TimestampableEntity;

    /**
     * Identifier.
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @OA\Property(type="integer", example="12")
     * @Expose()
     * @Serializer\Type("integer")
     */
    private $id;

    /**
     * Subject.
     *
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     * @OA\Property(type="string", example="Histoire")
     * @Expose()
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     */
    private $subject;

    /**
     * Note.
     *
     * @var float
     *
     * @ORM\Column(name="note", type="decimal", scale=2, precision=4)
     * @OA\Property(type="float", example="12.50")
     * @Expose()
     * @Serializer\Type("float")
     * @Assert\NotBlank()
     */
    private $note;

    /**
     * Student.
     *
     * @var Student
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Student")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", nullable=false)
     * @OA\Property(
     *     type="object",
     *     @OA\Schema(ref="#/components/schemas/Student")
     * )
     * @Assert\Valid()
     * @Expose()
     * @Assert\NotBlank()
     */
    private $student;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return float
     */
    public function getNote(): float
    {
        return $this->note;
    }

    /**
     * @param float $note
     */
    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return Student
     */
    public function getStudent(): Student
    {
        return $this->student;
    }

    /**
     * @param Student $student
     */
    public function setStudent(Student $student): self
    {
        $this->student = $student;

        return $this;
    }
}
