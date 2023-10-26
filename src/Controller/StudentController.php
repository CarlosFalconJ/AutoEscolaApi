<?php

namespace App\Controller;

use App\Dto\Student\RequestCreateStudent;
use App\Dto\Student\RequestDeleteStudent;
use App\Dto\Student\RequestUpdateStudent;
use App\Helper\NotificationError;
use App\Helper\RequestParamsParser;
use App\Helper\ResponseCodeGenericsHelper;
use App\Helper\ResponseHttpHelper;
use App\Service\Student\Storage\StudentStorage;
use App\Service\Student\StudentCreater;
use App\Service\Student\StudentDeletor;
use App\Service\Student\StudentSearching;
use App\Service\Student\StudentSearchingAll;
use App\Service\Student\StudentUpdater;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/api/register/drivingschool/{driving_school_id}/student', name: 'api_register_student', methods: 'post')]
    public function registerStudent(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['driving_school_id']);

            $notificationError = new NotificationError();

            $requestCreateStudent = RequestCreateStudent::create($data);

            $studentStorage = new StudentStorage($entityManager);

            $studentCreater = new StudentCreater($notificationError, $studentStorage);
            $studentCreater->create($requestCreateStudent);

            ResponseHttpHelper::setResponse($response, $notificationError, [], ResponseCodeGenericsHelper::CREATED);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/updater/drivingschool/student/{id}', name: 'api_updater_student', methods: 'put')]
    public function updaterStudent(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['id']);

            $notificationError = new NotificationError();

            $requestUpdateStudent = RequestUpdateStudent::create($data);

            $studentStorage = new StudentStorage($entityManager);

            $studentUpdater = new StudentUpdater($notificationError, $studentStorage);
            $studentUpdater->update($requestUpdateStudent);

            ResponseHttpHelper::setResponse($response, $notificationError, [], ResponseCodeGenericsHelper::OK);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/deletor/drivingschool/student/{id}', name: 'api_deletor_student', methods: 'delete')]
    public function deletorStudent(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['id']);

            $notificationError = new NotificationError();

            $requestDeleteStudent = RequestDeleteStudent::create($data);

            $studentStorage = new StudentStorage($entityManager);

            $studentDeletor = new StudentDeletor($notificationError, $studentStorage);
            $studentDeletor->delete($requestDeleteStudent);

            ResponseHttpHelper::setResponse($response, $notificationError, [], ResponseCodeGenericsHelper::NO_CONTENT);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/searching/all/drivingschool/{driving_school_id}/student', name: 'api_searching_all_student', methods: 'get')]
    public function searchingAllStudent(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['driving_school_id']);

            $notificationError = new NotificationError();

            $studentStorage = new StudentStorage($entityManager);

            $drivingSchoolId = (isset($data['driving_school_id']) && $data['driving_school_id'] > 0) ? $data['driving_school_id'] : null;

            $studentSearchingAll = new StudentSearchingAll($studentStorage);
            $studentInfo = $studentSearchingAll->searchAll($drivingSchoolId);

            ResponseHttpHelper::setResponse($response, $notificationError, $studentInfo, ResponseCodeGenericsHelper::OK);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/searching/drivingschool/student/{id}', name: 'api_searching_student', methods: 'get')]
    public function searchingStudent(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['id']);

            $notificationError = new NotificationError();

            $studentStorage = new StudentStorage($entityManager);

            $studentId = (isset($data['id']) && $data['id'] > 0) ? $data['id'] : null;

            $studentSearchingAll = new StudentSearching($studentStorage);
            $studentInfo = $studentSearchingAll->search($studentId);

            ResponseHttpHelper::setResponse($response, $notificationError, $studentInfo, ResponseCodeGenericsHelper::OK);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }
}