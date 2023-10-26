<?php

namespace App\Service\DrivingSchool;

use App\Dto\DrivingSchool\RequestSearchingDrivingSchool;
use App\Service\DrivingSchool\Entity\DrivingSchool;
use App\Service\DrivingSchool\Storage\DrivingSchoolStorageInterface;

class DrivingSchoolSearching
{
    private DrivingSchoolStorageInterface $drivingSchoolStorage;

    public function __construct(DrivingSchoolStorageInterface $drivingSchoolStorage)
    {
        $this->drivingSchoolStorage = $drivingSchoolStorage;
    }

    public function search(RequestSearchingDrivingSchool $requestSearchingDrivingSchool)
    {
        $drivingSchool = $this->createDrivingSchoolEntity($requestSearchingDrivingSchool);

        return $this->drivingSchoolStorage->searchDrivingSchool($drivingSchool->getId());
    }

    private function createDrivingSchoolEntity(RequestSearchingDrivingSchool $requestSearchingDrivingSchool)
    {
        return DrivingSchool::create(
            $requestSearchingDrivingSchool->id, null, null,
            null, null
        );
    }
}