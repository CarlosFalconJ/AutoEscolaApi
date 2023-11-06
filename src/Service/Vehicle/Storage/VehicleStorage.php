<?php

namespace App\Service\Vehicle\Storage;

use App\Entity\DrivingSchool;
use App\Entity\Vehicle;
use App\Service\Vehicle\Entity\VehicleEntity;
use Doctrine\ORM\EntityManagerInterface;

class VehicleStorage implements VehicleStorageInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function saveVehicle(VehicleEntity $vehicleEntity)
    {
        $drivingSchoolRepository = $this->entityManager->getRepository(DrivingSchool::class);
        $drivingSchool = $drivingSchoolRepository->find($vehicleEntity->getDrivingSchoolId());

        $vehicle = new Vehicle();
        $vehicle->setDrivingSchool($drivingSchool)->setPlate($vehicleEntity->getPlate())->setModel($vehicleEntity->getModel())
            ->setColor($vehicleEntity->getColor())->setRenavam($vehicleEntity->getRenavam());

        $this->entityManager->persist($vehicle);
        $this->entityManager->flush();
    }

    public function updateVehicle(VehicleEntity $vehicleEntity)
    {
        $vehicleRepository = $this->entityManager->getRepository(Vehicle::class);
        $vehicle = $vehicleRepository->find($vehicleEntity->getId());

        $vehicle->setPlate($vehicleEntity->getPlate())->setModel($vehicleEntity->getModel())
            ->setColor($vehicleEntity->getColor())->setRenavam($vehicleEntity->getRenavam());

        $this->entityManager->persist($vehicle);
        $this->entityManager->flush();
    }

    public function deleteVehicle(VehicleEntity $vehicleEntity)
    {
        $vehicleRepository = $this->entityManager->getRepository(Vehicle::class);
        $vehicle = $vehicleRepository->find($vehicleEntity->getId());

        $this->entityManager->remove($vehicle);
        $this->entityManager->flush();
    }

    public function getDrivingSchoolExists(?int $drivingSchoolId)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('ds.id')
            ->from(DrivingSchool::class, 'ds')
            ->where(
                $qb->expr()->eq('ds.id', ':drivingSchoolId')
            )
            ->setParameter('drivingSchoolId', $drivingSchoolId);

        $q = $qb->getQuery();

        try {
            $result = $q->getOneOrNullResult();

            $drivingSchoolExist = !is_null($result) && isset($result['id']) ? true : false;
        } catch (\Exception $e) {
            $drivingSchoolExist = false;
        }

        return $drivingSchoolExist;
    }

    public function getVehicleWithPlate(?int $vehicleId, ?string $plate)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('v.id')
            ->from(Vehicle::class, 'v')
            ->where(
                $qb->expr()->eq('v.plate', ':plate')
            )
            ->setParameter('plate', $plate);

        if ($vehicleId > 0) {
            $qb->andWhere($qb->expr()->neq("v.id", ":vehicleId"))
                ->setParameter("vehicleId", (int)$vehicleId);
        }

        $q = $qb->getQuery();

        try {
            $result = $q->getOneOrNullResult();

            $plateAlreadyRegistered = !is_null($result) && isset($result['id']) ? true : false;
        } catch (\Exception $e) {
            $plateAlreadyRegistered = false;
        }

        return $plateAlreadyRegistered;
    }

    public function getVehicleExists(?int $vehicleId)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('v.id')
            ->from(Vehicle::class, 'v')
            ->where(
                $qb->expr()->eq('v.id', ':vehicleId')
            )
            ->setParameter('vehicleId', $vehicleId);

        $q = $qb->getQuery();

        try {
            $result = $q->getOneOrNullResult();

            $vehicleExist = !is_null($result) && isset($result['id']) ? true : false;
        } catch (\Exception $e) {
            $vehicleExist = false;
        }

        return $vehicleExist;
    }

    public function getVehicleWithRenavam(?int $vehicleId, ?string $renavam)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('v.id')
            ->from(Vehicle::class, 'v')
            ->where(
                $qb->expr()->eq('v.renavam', ':renavam')
            )
            ->setParameter('renavam', $renavam);

        if ($vehicleId > 0) {
            $qb->andWhere($qb->expr()->neq("v.id", ":vehicleId"))
                ->setParameter("vehicleId", (int)$vehicleId);
        }

        $q = $qb->getQuery();

        try {
            $result = $q->getOneOrNullResult();

            $renavamAlreadyRegistered = !is_null($result) && isset($result['id']) ? true : false;
        } catch (\Exception $e) {
            $renavamAlreadyRegistered = false;
        }

        return $renavamAlreadyRegistered;
    }

    public function getAllVehiclesFromDrivingSchool(?int $drivingSchoolId)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('v.id, v.plate, v.model, v.color, v.renavam')
            ->from(Vehicle::class, 'v')
            ->where(
                $qb->expr()->eq('v.drivingSchool', ':drivingSchool')
            )
            ->setParameter('drivingSchool', $drivingSchoolId);

        $q = $qb->getQuery();

        try {
            $result = $q->getResult();
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }

    public function getVehicleById(?int $instructorId)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('v.id, v.plate, v.model, v.color, v.renavam')
            ->from(Vehicle::class, 'v')
            ->where(
                $qb->expr()->eq('v.id', ':instructorId')
            )
            ->setParameter('instructorId', $instructorId);

        $q = $qb->getQuery();

        try {
            $result = $q->getSingleResult();
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }
}