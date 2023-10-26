<?php

namespace App\Service\DrivingSchool\Storage;

use App\Service\DrivingSchool\Entity\DrivingSchool;

interface DrivingSchoolStorageInterface
{
    public function saveDrivingSchool(DrivingSchool $drivingSchool);

    public function getDrivingSchoolWithCnpj(int|null $idDrivingSchool, string $cnpj);

    public function updateDrivingSchool(DrivingSchool $drivingSchool);

    public function deleteDrivingSchool(DrivingSchool $drivingSchool);

    public function getDrivingSchooExists(int $idDrivingSchool);
}