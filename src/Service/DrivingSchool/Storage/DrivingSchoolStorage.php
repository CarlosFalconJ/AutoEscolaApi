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

    public function getDrivingSchoolWithCnpj(int|null $idDrivingSchool, string $cnpj)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('dse.id')
            ->from(DrivingSchoolEntity::class, 'dse')
            ->where(
                $qb->expr()->eq('dse.cnpj', ':cnpj')
            )
            ->setParameter('cnpj', $cnpj);

        if (is_numeric($idDrivingSchool) && $idDrivingSchool > 0 && !is_null($idDrivingSchool)) {
            $qb->andWhere($qb->expr()->neq("dse.id'", ":id"))
                ->setParameter('id', (int)$idDrivingSchool);
        }

        $q = $qb->getQuery();

        try {
            $cnpjAlreadyRegistered = !is_null($q->getSingleScalarResult()) ? true : false;
        } catch (\Exception $e) {
            $cnpjAlreadyRegistered = false;
        }

        return $cnpjAlreadyRegistered;
    }
}