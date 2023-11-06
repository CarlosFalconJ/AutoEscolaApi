<?php

namespace App\Controller;

use App\Dto\Vehicle\RequestCreateVehicle;
use App\Dto\Vehicle\RequestUpdateVehicle;
use App\Helper\NotificationError;
use App\Helper\RequestParamsParser;
use App\Helper\ResponseCodeGenericsHelper;
use App\Helper\ResponseHttpHelper;
use App\Service\Vehicle\Storage\VehicleStorage;
use App\Service\Vehicle\VehicleCreater;
use App\Service\Vehicle\VehicleDeletor;
use App\Service\Vehicle\VehicleSearching;
use App\Service\Vehicle\VehicleSearchingAll;
use App\Service\Vehicle\VehicleUpdater;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VehicleController extends AbstractController
{
    #[Route('/api/register/drivingschool/{driving_school_id}/vehicle', name: 'api_register_vehicle', methods: 'post')]
    public function registerVehicle(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['driving_school_id']);

            $notificationError = new NotificationError();

            $requestCreateVehicle = RequestCreateVehicle::create($data);

            $vehicleStorage = new VehicleStorage($entityManager);

            $studentCreater = new VehicleCreater($notificationError, $vehicleStorage);
            $studentCreater->create($requestCreateVehicle);

            ResponseHttpHelper::setResponse($response, $notificationError, [], ResponseCodeGenericsHelper::CREATED);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/updater/drivingschool/vehicle/{id}', name: 'api_updater_vehicle', methods: 'put')]
    public function updaterVehicle(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['id']);

            $notificationError = new NotificationError();

            $requestUpdateVehicle = RequestUpdateVehicle::create($data);

            $vehicleStorage = new VehicleStorage($entityManager);

            $studentUpdater = new VehicleUpdater($notificationError, $vehicleStorage);
            $studentUpdater->update($requestUpdateVehicle);

            ResponseHttpHelper::setResponse($response, $notificationError, [], ResponseCodeGenericsHelper::OK);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/deletor/drivingschool/vehicle/{id}', name: 'api_deletor_vehicle', methods: 'delete')]
    public function deletorVehicle(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['id']);

            $notificationError = new NotificationError();

            $instructorId = (isset($data['id']) && $data['id'] > 0) ? (int)$data['id'] : null;

            $vehicleStorage = new VehicleStorage($entityManager);

            $vehicleDeletor = new VehicleDeletor($notificationError, $vehicleStorage);
            $vehicleDeletor->delete($instructorId);

            ResponseHttpHelper::setResponse($response, $notificationError, [], ResponseCodeGenericsHelper::NO_CONTENT);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/searching/all/drivingschool/{driving_school_id}/vehicle', name: 'api_searching_all_vehicle', methods: 'get')]
    public function searchingAllvehicle(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['driving_school_id']);

            $notificationError = new NotificationError();

            $vehicleStorage = new VehicleStorage($entityManager);

            $drivingSchoolId = (isset($data['driving_school_id']) && $data['driving_school_id'] > 0) ? (int)$data['driving_school_id'] : null;

            $vehicleSearchingAll = new VehicleSearchingAll($vehicleStorage);
            $vehicleInfo = $vehicleSearchingAll->searchAll($drivingSchoolId);

            ResponseHttpHelper::setResponse($response, $notificationError, $vehicleInfo, ResponseCodeGenericsHelper::OK);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }

    #[Route('/api/searching/drivingschool/vehicle/{id}', name: 'api_searching_vehicle', methods: 'get')]
    public function searchingVehicle(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $data = RequestParamsParser::requestToArray($request, ['id']);

            $notificationError = new NotificationError();

            $vehicleStorage = new VehicleStorage($entityManager);

            $instructorId = (isset($data['id']) && $data['id'] > 0) ? (int)$data['id'] : null;

            $vehicleSearchingAll = new VehicleSearching($vehicleStorage);
            $vehicleInfo = $vehicleSearchingAll->search($instructorId);

            ResponseHttpHelper::setResponse($response, $notificationError, $vehicleInfo, ResponseCodeGenericsHelper::OK);
        } catch (\Exception $exception) {
            $response = ResponseHttpHelper::getResponseError($exception);
        }

        return $response;
    }
}