<?php

namespace App\Model;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="SubjectNoteInformation",
 *     type="object",
 *     description="Subject note information model",
 *     @OA\Property(type="string", property="subject", example="Mathematique"),
 *     @OA\Property(type="float", property="note", example="12"),
 *     @OA\Property(type="integer", property="student_id", example="1")
 * )
 */
class SubjectNoteInformationModel
{
    /**
     * @var string
     */
    private $subject;

    /**
     * @var float
     */
    private $note;

    /**
     * @var int
     */
    private $studentId;

    /**
     * SubjectNoteModel constructor.
     *
     * @param string $subject
     * @param float $note
     * @param int $studentId
     */
    public function __construct(string $subject, float $note, int $studentId)
    {
        $this->subject = $subject;
        $this->note = $note;
        $this->studentId = $studentId;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return float
     */
    public function getNote(): float
    {
        return $this->note;
    }

    /**
     * @return int
     */
    public function getStudentId(): int
    {
        return $this->studentId;
    }
}
