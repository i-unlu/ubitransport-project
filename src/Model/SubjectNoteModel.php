<?php

namespace App\Model;

class SubjectNoteModel
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
