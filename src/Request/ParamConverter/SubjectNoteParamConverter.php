<?php

namespace App\Request\ParamConverter;

use App\Entity\SubjectNote;
use App\Repository\StudentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SubjectNoteParamConverter implements ParamConverterInterface
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * SubjectNoteParamConverter constructor.
     *
     * @param StudentRepository $studentRepository
     */
    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * @inheritDoc
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === SubjectNote::class;
    }

    /**
     * @inheritDoc
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $data = \json_decode($request->getContent(), true);
        $student = $this->studentRepository->find((int) $data['student_id']);

        if (null === $student) {
            throw new NotFoundHttpException('Student no found.');
        }

        $subjectNote = (new SubjectNote())
            ->setNote((float) $data['note'])
            ->setSubject($data['subject'])
            ->setStudent($student)
        ;

        $request->attributes->set($configuration->getName(), $subjectNote);
    }
}
