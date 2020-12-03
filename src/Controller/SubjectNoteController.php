<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\SubjectNote;
use App\Helper\RequestBodyViolationHelper;
use App\Repository\SubjectNoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\View\View as FostRestView;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SubjectNoteController extends AbstractFOSRestController
{
    /**
     * Add a subject note.
     *
     * @OA\Post(
     *  path="",
     *  summary="Add a subject note",
     *  description="Add a subject note",
     *  security={{"bearer":{}}},
     *  tags={"SubjectNote"},
     *  operationId="addSubjectNote",
     *  @OA\Parameter(
     *      name="subjectNote",
     *      in="query",
     *      description="subject note to add",
     *      required=true,
     *      @OA\Schema(
     *          ref="#/components/schemas/SubjectNote"
     *      ),
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Subject note added",
     *      @OA\JsonContent(ref="#/components/schemas/SubjectNote")
     *  ),
     *  @OA\Response(
     *      response="404",
     *      description="Student no found"
     *  ),
     *  @OA\Response(
     *      response="422",
     *      description="Invalid subject note",
     *      @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *  ),
     *  @OA\Response(
     *      response="503",
     *      description="Maintenance site"
     *  ),
     *  @OA\Response(
     *      response="default",
     *      description="an ""unexpected"" error"
     *  )
     * )
     *
     * @Rest\Post(
     *     name="subject_note_add",
     *     options={ "method_prefix" = false }
     * )
     *
     * @ParamConverter("subjectNote", converter="subject_note_converter")
     *
     * @View()
     */
    public function addSubjectNote(SubjectNote $subjectNote, EntityManagerInterface $entityManager, ValidatorInterface $validator, RequestBodyViolationHelper $requestBodyViolationHelper): FostRestView
    {
        $violationView = $requestBodyViolationHelper->handle($validator->validate($subjectNote));

        if (null !== $violationView) {
            return $violationView;
        }

        $entityManager->persist($subjectNote);
        $entityManager->flush();

        return $this->view($subjectNote);
    }

    /**
     * Get average note for all students.
     *
     * @OA\Get(
     *  path="/average-note",
     *  summary="Get average note for all students",
     *  description="Get average note for all students",
     *  security={{"bearer":{}}},
     *  tags={"SubjectNote"},
     *  operationId="getAverageNote",
     *  @OA\Response(
     *      response=200,
     *      description="Get average note calculated for all students.",
     *      @OA\JsonContent(
     *          @OA\Property(
     *              property="average",
     *              type="float"
     *          )
     *     )
     *  ),
     *  @OA\Response(
     *      response="503",
     *      description="Maintenance site"
     *  ),
     *  @OA\Response(
     *      response="default",
     *      description="an ""unexpected"" error"
     *  )
     * )
     *
     * @Rest\Get(
     *     "/average-note",
     *     name="subject_note_average_note",
     *     options={ "method_prefix" = false }
     * )
     *
     * @View()
     */
    public function getAverageNote(SubjectNoteRepository $subjectNoteRepository): FostRestView
    {
        return $this->view($subjectNoteRepository->getAverageNoteForAllStudents());
    }
}
