<?php

namespace App\Helper;

use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Request Body Violation Helper provides a method to handle a list of error into a standard FOS View.
 */
class RequestBodyViolationHelper
{
    /**
     * Handles the given error list.
     *
     * @param ConstraintViolationListInterface $errors List of errors
     *
     * @return View|null Returns null if there's no error
     */
    public function handle(ConstraintViolationListInterface $errors): ?View
    {
        if (0 === count($errors)) {
            return null;
        }

        $data = [];

        /** @var ConstraintViolationInterface $error */
        foreach ($errors as $error) {
            $data[] = ['property_path' => $error->getPropertyPath(), 'message' => $error->getMessage()];
        }

        return View::create($data, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
