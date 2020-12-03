<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Student.
 *
 * @ORM\Table(name="student")
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 *
 * @OA\Schema(
 *     schema="Student",
 *     type="object",
 *     description="Student model",
 *     required={"lastName", "firstName"}
 * )
 *
 * @ExclusionPolicy("all")
 */
class Student
{
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
     * Last name.
     *
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     * @OA\Property(type="string", example="UNLU")
     * @Expose()
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * Last name.
     *
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     * @OA\Property(type="string", example="izzetali")
     * @Expose()
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * Birth date.
     *
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="birth_date", type="date")
     * @OA\Property(type="string", format="date", example="1981-03-22")
     * @Expose()
     * @Serializer\Type("DateTime<'Y-m-d'>")
     * @Assert\NotBlank()
     */
    private $birthDate;

    /**
     * Get identifier.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getBirthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTimeInterface $birthDate
     */
    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }
}
