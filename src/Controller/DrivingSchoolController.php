<?php

namespace App\Controller;

use App\Dto\RequestCreateDrivingSchool;
use App\Dto\RequestDeleteDrivingSchool;
use App\Dto\RequestUpdateDrivingSchool;
use App\Helper\NotificationError;
use App\Helper\RequestParamsParser;
use App\Helper\ResponseCodeGenericsHelper;
use App\Helper\ResponseHttpHelper;
use App\Service\DrivingSchool\DrivingSchoolCreater;
use App\Service\DrivingSchool\DrivingSchoolDeletor;
use App\Service\DrivingSchool\DrivingSchoolUpdater;
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

            ResponseHttpHelper::setResponse($response, $notificationError, [], ResponseCodeGenericsHelper::CREATED);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/updater/drivingschool/{id}', name: 'api_updater_drivingschool', methods: 'put')]
    public function updaterStudent(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['id']);

            $notificationError = new NotificationError();

            $requestUpdateDrivingSchool = RequestUpdateDrivingSchool::create($data);

            $drivingSchoolStorage = new DrivingSchoolStorage($entityManager);

            $drivingSchoolUpdater = new DrivingSchoolUpdater($notificationError, $drivingSchoolStorage);
            $drivingSchoolUpdater->update($requestUpdateDrivingSchool);

            ResponseHttpHelper::setResponse($response, $notificationError, [], ResponseCodeGenericsHelper::OK);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/deletor/drivingschool/{id}', name: 'api_deletor_drivingschool', methods: 'delete')]
    public function deletorStudent(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['id']);

            $notificationError = new NotificationError();

            $requestDeleteDrivingSchool = RequestDeleteDrivingSchool::create($data);

            $drivingSchoolStorage = new DrivingSchoolStorage($entityManager);

            $drivingSchoolDeletor = new DrivingSchoolDeletor($notificationError, $drivingSchoolStorage);
            $drivingSchoolDeletor->delete($requestDeleteDrivingSchool);

            ResponseHttpHelper::setResponse($response, $notificationError, [], ResponseCodeGenericsHelper::NO_CONTENT);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }
}