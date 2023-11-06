<?php

namespace App\Controller;

use App\Dto\Classroom\RequestCreateClassroom;
use App\Dto\Classroom\RequestUpdateClassroom;
use App\Helper\NotificationError;
use App\Helper\RequestParamsParser;
use App\Helper\ResponseCodeGenericsHelper;
use App\Helper\ResponseHttpHelper;
use App\Service\Classroom\ClassroomCreater;
use App\Service\Classroom\ClassroomDeletor;
use App\Service\Classroom\ClassroomSearching;
use App\Service\Classroom\ClassroomSearchingAll;
use App\Service\Classroom\ClassroomUpdater;
use App\Service\Classroom\Storage\ClassroomStorage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    #[Route('/api/register/drivingschool/{driving_school_id}/classroom', name: 'api_register_classroom', methods: 'post')]
    public function registerClassroom(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['driving_school_id']);

            $notificationError = new NotificationError();

            $requestCreateClassroom = RequestCreateClassroom::create($data);

            $classroomStorage = new ClassroomStorage($entityManager);

            $classroomCreater = new ClassroomCreater($notificationError, $classroomStorage);
            $classroomCreater->create($requestCreateClassroom);

            ResponseHttpHelper::setResponse($response, $notificationError, [], ResponseCodeGenericsHelper::CREATED);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/updater/drivingschool/classroom/{id}', name: 'api_updater_classroom', methods: 'put')]
    public function updaterClassroom(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['id']);

            $notificationError = new NotificationError();

            $requestUpdateClassroom = RequestUpdateClassroom::create($data);

            $classroomStorage = new ClassroomStorage($entityManager);

            $studentUpdater = new ClassroomUpdater($notificationError, $classroomStorage);
            $studentUpdater->update($requestUpdateClassroom);

            ResponseHttpHelper::setResponse($response, $notificationError, [], ResponseCodeGenericsHelper::OK);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/deletor/drivingschool/classroom/{id}', name: 'api_deletor_classroom', methods: 'delete')]
    public function deletorClassroom(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['id']);

            $notificationError = new NotificationError();

            $classroomId = (isset($data['id']) && $data['id'] > 0) ? (int)$data['id'] : null;

            $classroomStorage = new ClassroomStorage($entityManager);

            $instructorDeletor = new ClassroomDeletor($notificationError, $classroomStorage);
            $instructorDeletor->delete($classroomId);

            ResponseHttpHelper::setResponse($response, $notificationError, [], ResponseCodeGenericsHelper::NO_CONTENT);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/searching/all/drivingschool/{driving_school_id}/classroom', name: 'api_searching_all_classroom', methods: 'get')]
    public function searchingAllClassroom(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['driving_school_id']);

            $notificationError = new NotificationError();

            $classroomStorage = new ClassroomStorage($entityManager);

            $drivingSchoolId = (isset($data['driving_school_id']) && $data['driving_school_id'] > 0) ? (int)$data['driving_school_id'] : null;

            $calssroomSearchingAll = new ClassroomSearchingAll($classroomStorage);
            $calssroomInfo = $calssroomSearchingAll->searchAll($drivingSchoolId);

            ResponseHttpHelper::setResponse($response, $notificationError, $calssroomInfo, ResponseCodeGenericsHelper::OK);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/searching/drivingschool/classroom/{id}', name: 'api_searching_classroom', methods: 'get')]
    public function searchingClassroom(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['id']);

            $notificationError = new NotificationError();

            $classroomStorage = new ClassroomStorage($entityManager);

            $classroomId = (isset($data['id']) && $data['id'] > 0) ? (int)$data['id'] : null;

            $classroomSearchingAll = new ClassroomSearching($classroomStorage);
            $classroomInfo = $classroomSearchingAll->search($classroomId);

            ResponseHttpHelper::setResponse($response, $notificationError, $classroomInfo, ResponseCodeGenericsHelper::OK);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }
}