<?php

namespace App\Controller;

use App\Entity\Student;
use App\Helper\RequestBodyViolationHelper;
use App\Model\StudentInformation;
use App\Repository\SubjectNoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\View\View as FostRestView;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class StudentController extends AbstractFOSRestController
{
    /**
     * Add a student.
     *
     * @OA\Post(
     *  path="/student",
     *  summary="Add a student",
     *  description="Add a student",
     *  tags={"Student"},
     *  operationId="addStudent",
     *  @OA\RequestBody(
     *      description="Student informations to edit",
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/Student"),
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Student added",
     *      @OA\JsonContent(ref="#/components/schemas/Student")
     *  ),
     *  @OA\Response(
     *      response="422",
     *      description="Request body not matching with student model",
     *      @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *  )
     * )
     *
     * @Rest\Post(
     *     name="student_add",
     *     options={ "method_prefix" = false }
     * )
     *
     * @ParamConverter("student", converter="fos_rest.request_body")
     *
     * @View()
     */
    public function addStudent(Student $student, EntityManagerInterface $entityManager, ConstraintViolationListInterface $errors, RequestBodyViolationHelper $requestBodyViolationHelper): FostRestView
    {
        $violationView = $requestBodyViolationHelper->handle($errors);

        if (null !== $violationView) {
            return $violationView;
        }

        $entityManager->persist($student);
        $entityManager->flush();

        return $this->view($student, Response::HTTP_CREATED);
    }

    /**
     * Edit a student.
     *
     * @OA\Put(
     *  path="/student/{studentToEdit}",
     *  summary="Edit a student",
     *  description="Edit a student",
     *  security={{"bearer":{}}},
     *  tags={"Student"},
     *  operationId="editStudent",
     *  @OA\Parameter(
     *      name="studentToEdit",
     *      in="path",
     *      description="student to edit",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      ),
     *  ),
     *  @OA\RequestBody(
     *      description="Student informations to edit",
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/Student"),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Student edited"
     *  ),
     *  @OA\Response(
     *      response="404",
     *      description="studentToEdit identifier in path no found"
     *  ),
     *  @OA\Response(
     *      response="422",
     *      description="Request body not matching with student model"
     *  )
     * )
     *
     * @Rest\Put(
     *     "/{studentToEdit}",
     *     name="student_edit",
     *     requirements={"studentToEdit"="\d+"},
     *     options={ "method_prefix" = false }
     * )
     *
     * @ParamConverter("studentInformations", converter="fos_rest.request_body")
     *
     * @View()
     */
    public function editStudent(Student $studentToEdit, Student $studentInformations, EntityManagerInterface $entityManager, ConstraintViolationListInterface $errors, RequestBodyViolationHelper $requestBodyViolationHelper): FostRestView
    {
        $violationView = $requestBodyViolationHelper->handle($errors);

        if (null !== $violationView) {
            return $violationView;
        }

        $studentToEdit->setFirstName($studentInformations->getFirstName());
        $studentToEdit->setLastName($studentInformations->getLastName());
        $studentToEdit->setBirthDate($studentInformations->getBirthDate());

        $entityManager->persist($studentToEdit);
        $entityManager->flush();

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Delete a student.
     *
     * @OA\Delete(
     *  path="/student/{studentToDelete}",
     *  summary="Delete a student",
     *  description="Delete a student",
     *  security={{"bearer":{}}},
     *  tags={"Student"},
     *  operationId="deleteStudent",
     *  @OA\Parameter(
     *      name="studentToDelete",
     *      in="path",
     *      description="student to delete",
     *      required=true,
     *      @OA\Schema(
     *          ref="#/components/schemas/Student"
     *      ),
     *  ),
     *  @OA\Response(
     *      response=204,
     *      description="Student deleted"
     *  ),
     *  @OA\Response(
     *      response="404",
     *      description="Student no found"
     *  )
     * )
     *
     * @Rest\Delete(
     *     "/{studentToDelete}",
     *     name="student_delete",
     *     requirements={"studentToDelete"="\d+"},
     *     options={ "method_prefix" = false }
     * )
     *
     * @View()
     */
    public function deleteStudent(Student $studentToDelete, EntityManagerInterface $entityManager): FostRestView
    {
        $entityManager->remove($studentToDelete);
        $entityManager->flush();

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Get average note for a student.
     *
     * @OA\Get(
     *  path="/student/{student}/average-note",
     *  summary="Get average note for a student",
     *  description="Get average note for a student",
     *  security={{"bearer":{}}},
     *  tags={"Student"},
     *  operationId="getAverageNoteByStudent",
     *  @OA\Parameter(
     *      name="student",
     *      in="path",
     *      description="student for which the average is calculated",
     *      required=true,
     *      @OA\Schema(
     *          ref="#/components/schemas/Student"
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Get average note calculated",
     *      @OA\JsonContent(
     *          @OA\Property(
     *              property="average",
     *              type="float"
     *          )
     *     )
     *  ),
     *  @OA\Response(
     *      response="404",
     *      description="Student no found"
     *  )
     * )
     *
     * @Rest\Get(
     *     "/{student}/average-note",
     *     name="student_average_note",
     *     options={ "method_prefix" = false }
     * )
     *
     * @View()
     */
    public function getAverageNoteByStudent(Student $student, SubjectNoteRepository $subjectNoteRepository): FostRestView
    {
        return $this->view($subjectNoteRepository->getAverageNote($student));
    }
}
