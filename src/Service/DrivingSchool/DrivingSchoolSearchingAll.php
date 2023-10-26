<?php

namespace App\Service\DrivingSchool;

use App\Service\DrivingSchool\Storage\DrivingSchoolStorageInterface;

class DrivingSchoolSearchingAll
{
    private DrivingSchoolStorageInterface $drivingSchoolStorage;

    public function __construct(DrivingSchoolStorageInterface $drivingSchoolStorage)
    {
        $this->drivingSchoolStorage = $drivingSchoolStorage;
    }

    public function searchAll()
    {
        return $this->drivingSchoolStorage->searchAllDrivingSchool();
    }
}