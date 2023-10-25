<?php

namespace App\Controller;

use App\Dto\RequestCreateDrivingSchool;
use App\Helper\NotificationError;
use App\Helper\RequestParamsParser;
use App\Helper\ResponseCodeGenericsHelper;
use App\Helper\ResponseHttpHelper;
use App\Service\DrivingSchool\DrivingSchoolCreater;
use App\Service\DrivingSchool\Storage\DrivingSchoolStorage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DrivingSchoolController extends AbstractController
{
    #[Route('/api/register/drivingschool', name: 'api_register_drivingschool', methods: 'post')]
    public function registerStudent(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request);

            $notificationError = new NotificationError();

            $requestCreateDrivingSchool = RequestCreateDrivingSchool::create($data);

            $drivingSchoolStorage = new DrivingSchoolStorage($entityManager);

            $drivingSchoolCreater = new DrivingSchoolCreater($notificationError, $drivingSchoolStorage);
            $drivingSchoolCreater->create($requestCreateDrivingSchool);

            ResponseHttpHelper::setResponse($response, $notificationError, [], ResponseCodeGenericsHelper::NO_CONTENT);
        }catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }
}