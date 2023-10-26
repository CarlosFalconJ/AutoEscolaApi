<?php

namespace App\Controller;

use App\Dto\DrivingSchool\RequestCreateDrivingSchool;
use App\Dto\DrivingSchool\RequestDeleteDrivingSchool;
use App\Dto\DrivingSchool\RequestSearchingDrivingSchool;
use App\Dto\DrivingSchool\RequestUpdateDrivingSchool;
use App\Helper\NotificationError;
use App\Helper\RequestParamsParser;
use App\Helper\ResponseCodeGenericsHelper;
use App\Helper\ResponseHttpHelper;
use App\Service\DrivingSchool\DrivingSchoolCreater;
use App\Service\DrivingSchool\DrivingSchoolDeletor;
use App\Service\DrivingSchool\DrivingSchoolSearching;
use App\Service\DrivingSchool\DrivingSchoolSearchingAll;
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
    public function registerDrivingSchool(Request $request, EntityManagerInterface $entityManager): JsonResponse
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
    public function updaterDrivingSchool(Request $request, EntityManagerInterface $entityManager): JsonResponse
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
    public function deletorDrivingSchool(Request $request, EntityManagerInterface $entityManager): JsonResponse
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

    #[Route('/api/searching/all/drivingschool', name: 'api_searching_all_drivingschool', methods: 'get')]
    public function searchingAllDrivingSchool(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $notificationError = new NotificationError();

            $drivingSchoolStorage = new DrivingSchoolStorage($entityManager);

            $drivingSchoolSearchingAll = new DrivingSchoolSearchingAll($drivingSchoolStorage);
            $drivingSchoolInfo = $drivingSchoolSearchingAll->searchAll();

            ResponseHttpHelper::setResponse($response, $notificationError, $drivingSchoolInfo, ResponseCodeGenericsHelper::OK);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/searching/drivingschool/{id}', name: 'api_searching_drivingschool', methods: 'get')]
    public function searchingDrivingSchool(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['id']);

            $notificationError = new NotificationError();

            $requestSearchingDrivingSchool = RequestSearchingDrivingSchool::create($data);

            $drivingSchoolStorage = new DrivingSchoolStorage($entityManager);

            $drivingSchoolSearching = new DrivingSchoolSearching($drivingSchoolStorage);
            $drivingSchoolInfo = $drivingSchoolSearching->search($requestSearchingDrivingSchool);

            ResponseHttpHelper::setResponse($response, $notificationError, $drivingSchoolInfo, ResponseCodeGenericsHelper::OK);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }
}