<?php

namespace App\Service\DrivingSchool\Storage;

use App\Entity\DrivingSchool as DrivingSchoolEntity;
use App\Service\DrivingSchool\Entity\DrivingSchool;
use Doctrine\ORM\EntityManagerInterface;

class DrivingSchoolStorage implements DrivingSchoolStorageInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function saveDrivingSchool(DrivingSchool $drivingSchool)
    {
        $drivingSchoolEntity = new DrivingSchoolEntity();
        $drivingSchoolEntity->setName($drivingSchool->getName())
            ->setPhone($drivingSchool->getPhone())
            ->setCnpj($drivingSchool->getCnpj())
            ->setAddress($drivingSchool->getAddress());

        $this->entityManager->persist($drivingSchoolEntity);
        $this->entityManager->flush();
    }

    public function updateDrivingSchool(DrivingSchool $drivingSchool)
    {
        $drivingSchoolEntityRepository = $this->entityManager->getRepository(DrivingSchoolEntity::class);
        $drivingSchoolEntity = $drivingSchoolEntityRepository->find($drivingSchool->getId());

        $drivingSchoolEntity->setName($drivingSchool->getName())
            ->setPhone($drivingSchool->getPhone())
            ->setCnpj($drivingSchool->getCnpj())
            ->setAddress($drivingSchool->getAddress());

        $this->entityManager->persist($drivingSchoolEntity);
        $this->entityManager->flush();
    }

    public function deleteDrivingSchool(DrivingSchool $drivingSchool)
    {
        $drivingSchoolEntityRepository = $this->entityManager->getRepository(DrivingSchoolEntity::class);
        $drivingSchoolEntity = $drivingSchoolEntityRepository->find($drivingSchool->getId());

        $this->entityManager->remove($drivingSchoolEntity);
        $this->entityManager->flush();
    }

    public function getDrivingSchoolWithCnpj(int|null $idDrivingSchool, string $cnpj)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('dse.id')
            ->from(DrivingSchoolEntity::class, 'dse')
            ->where(
                $qb->expr()->eq('dse.cnpj', ':cnpj')
            )
            ->setParameter('cnpj', $cnpj);

        if ($idDrivingSchool > 0) {
            $qb->andWhere($qb->expr()->neq("dse.id", ":idDrivingSchool"))
                ->setParameter("idDrivingSchool", (int)$idDrivingSchool);
        }

        $q = $qb->getQuery();

        try {
            $result = $q->getOneOrNullResult();

            $cnpjAlreadyRegistered = !is_null($result) && isset($result['id']) ? true : false;
        } catch (\Exception $e) {
            $cnpjAlreadyRegistered = false;
        }

        return $cnpjAlreadyRegistered;
    }

    public function getDrivingSchooExists(int $idDrivingSchool)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('dse.id')
            ->from(DrivingSchoolEntity::class, 'dse')
            ->where(
                $qb->expr()->eq('dse.id', ':idDrivingSchool')
            )
            ->setParameter('idDrivingSchool', $idDrivingSchool);

        $q = $qb->getQuery();

        try {
            $result = $q->getOneOrNullResult();

            $drivingSchooExists = !is_null($result) && isset($result['id']) ? true : false;
        } catch (\Exception $e) {
            $drivingSchooExists = false;
        }

        return $drivingSchooExists;
    }

    public function searchDrivingSchool($idDrivingSchool)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('dse.id, dse.name, dse.cnpj, dse.address, dse.phone')
            ->from(DrivingSchoolEntity::class, 'dse')
            ->where(
                $qb->expr()->eq('dse.id', ':idDrivingSchool')
            )
            ->setParameter('idDrivingSchool', $idDrivingSchool);

        $q = $qb->getQuery();

        try {
            $drivingSchoolInfo = $q->getSingleResult();
        } catch (\Exception $e) {
            $drivingSchoolInfo = false;
        }

        return $drivingSchoolInfo;
    }

    public function searchAllDrivingSchool()
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('dse.id, dse.name, dse.cnpj, dse.address, dse.phone')
            ->from(DrivingSchoolEntity::class, 'dse');

        $q = $qb->getQuery();

        try {
            $drivingSchoolInfo = $q->getResult();
        } catch (\Exception $e) {
            $drivingSchoolInfo = false;
        }

        return $drivingSchoolInfo;
    }
}