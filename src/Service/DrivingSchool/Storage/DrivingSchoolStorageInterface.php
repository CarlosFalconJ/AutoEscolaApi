<?php

namespace App\Service\DrivingSchool\Storage;

use App\Service\DrivingSchool\Entity\DrivingSchool;

interface DrivingSchoolStorageInterface
{
    public function saveDrivingSchool(DrivingSchool $drivingSchool);

    public function getDrivingSchoolWithCnpj(int|null $idDrivingSchool, string $cnpj);
}