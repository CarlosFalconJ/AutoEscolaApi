<?php

namespace App\Controller;

use App\Dto\Instructor\RequestCreateInstructor;
use App\Dto\Instructor\RequestDeleteInstructor;
use App\Dto\Instructor\RequestUpdateInstructor;
use App\Helper\NotificationError;
use App\Helper\RequestParamsParser;
use App\Helper\ResponseCodeGenericsHelper;
use App\Helper\ResponseHttpHelper;
use App\Service\Instructor\InstructorCreater;
use App\Service\Instructor\InstructorDeletor;
use App\Service\Instructor\InstructorSearching;
use App\Service\Instructor\InstructorSearchingAll;
use App\Service\Instructor\InstructorUpdater;
use App\Service\Instructor\Storage\InstructorStorage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InstructorController extends AbstractController
{
    #[Route('/api/register/drivingschool/{driving_school_id}/instructor', name: 'api_register_instructor', methods: 'post')]
    public function registerInstructor(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['driving_school_id']);

            $notificationError = new NotificationError();

            $requestCreateInstructor = RequestCreateInstructor::create($data);

            $instructorStorage = new InstructorStorage($entityManager);

            $studentCreater = new InstructorCreater($notificationError, $instructorStorage);
            $studentCreater->create($requestCreateInstructor);

            ResponseHttpHelper::setResponse($response, $notificationError, [], ResponseCodeGenericsHelper::CREATED);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/updater/drivingschool/instructor/{id}', name: 'api_updater_instructor', methods: 'put')]
    public function updaterInstructor(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['id']);

            $notificationError = new NotificationError();

            $requestUpdateInstructor = RequestUpdateInstructor::create($data);

            $instructorStorage = new InstructorStorage($entityManager);

            $studentUpdater = new InstructorUpdater($notificationError, $instructorStorage);
            $studentUpdater->update($requestUpdateInstructor);

            ResponseHttpHelper::setResponse($response, $notificationError, [], ResponseCodeGenericsHelper::OK);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/deletor/drivingschool/instructor/{id}', name: 'api_deletor_instructor', methods: 'delete')]
    public function deletorInstructor(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['id']);

            $notificationError = new NotificationError();

            $requestDeleteInstructor = RequestDeleteInstructor::create($data);

            $instructorStorage = new InstructorStorage($entityManager);

            $instructorDeletor = new InstructorDeletor($notificationError, $instructorStorage);
            $instructorDeletor->delete($requestDeleteInstructor);

            ResponseHttpHelper::setResponse($response, $notificationError, [], ResponseCodeGenericsHelper::NO_CONTENT);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/searching/all/drivingschool/{driving_school_id}/instructors', name: 'api_searching_all_instructors', methods: 'get')]
    public function searchingAllInstructor(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['driving_school_id']);

            $notificationError = new NotificationError();

            $instructorStorage = new InstructorStorage($entityManager);

            $drivingSchoolId = (isset($data['driving_school_id']) && $data['driving_school_id'] > 0) ? (int)$data['driving_school_id'] : null;

            $instructorSearchingAll = new InstructorSearchingAll($instructorStorage);
            $instructorInfo = $instructorSearchingAll->searchAll($drivingSchoolId);

            ResponseHttpHelper::setResponse($response, $notificationError, $instructorInfo, ResponseCodeGenericsHelper::OK);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/searching/drivingschool/instructor/{id}', name: 'api_searching_instructor', methods: 'get')]
    public function searchingInstructor(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['id']);

            $notificationError = new NotificationError();

            $instructorStorage = new InstructorStorage($entityManager);

            $instructorId = (isset($data['id']) && $data['id'] > 0) ? (int)$data['id'] : null;

            $instructorSearchingAll = new InstructorSearching($instructorStorage);
            $instructorInfo = $instructorSearchingAll->search($instructorId);

            ResponseHttpHelper::setResponse($response, $notificationError, $instructorInfo, ResponseCodeGenericsHelper::OK);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }
}