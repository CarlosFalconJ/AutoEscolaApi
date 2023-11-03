<?php

namespace App\Service\Instructor\Storage;

use App\Entity\DrivingSchool;
use App\Entity\Instructor;
use App\Service\Instructor\Entity\InstructorEntity;
use Doctrine\ORM\EntityManagerInterface;

class InstructorStorage implements InstructorStorageInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function saveInstructor(InstructorEntity $instructorEntity)
    {
        $drivingSchoolRepository = $this->entityManager->getRepository(DrivingSchool::class);
        $drivingSchool = $drivingSchoolRepository->find($instructorEntity->getDrivingSchoolId());

        $instructor = new Instructor();
        $instructor->setDrivingSchool($drivingSchool)
            ->setName($instructorEntity->getName())
            ->setEmail($instructorEntity->getEmail())
            ->setPhone($instructorEntity->getPhone())
            ->setCpf($instructorEntity->getCpf())
            ->setBirthDate(new \DateTime($instructorEntity->getBirthDate()))
            ->setCategory($instructorEntity->getCategory());

        $this->entityManager->persist($instructor);
        $this->entityManager->flush();
    }

    public function updateInstructor(InstructorEntity $instructorEntity)
    {
        $instructorRepository = $this->entityManager->getRepository(Instructor::class);
        $instructor = $instructorRepository->find($instructorEntity->getId());

        $instructor->setName($instructorEntity->getName())
            ->setEmail($instructorEntity->getEmail())
            ->setPhone($instructorEntity->getPhone())
            ->setCpf($instructorEntity->getCpf())
            ->setBirthDate(new \DateTime($instructorEntity->getBirthDate()))
            ->setCategory($instructorEntity->getCategory());

        $this->entityManager->persist($instructor);
        $this->entityManager->flush();
    }

    public function deleteInstructor(InstructorEntity $instructorEntity)
    {
        $instructorRepository = $this->entityManager->getRepository(Instructor::class);
        $instructor = $instructorRepository->find($instructorEntity->getId());

        $this->entityManager->remove($instructor);
        $this->entityManager->flush();
    }

    public function getInstructorWithCpf(int|null $instructorId, string|null $cpf)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('i.id')
            ->from(Instructor::class, 'i')
            ->where(
                $qb->expr()->eq('i.cpf', ':cpf')
            )
            ->setParameter('cpf', $cpf);

        if ($instructorId > 0) {
            $qb->andWhere($qb->expr()->neq("i.id", ":instructorId"))
                ->setParameter("instructorId", (int)$instructorId);
        }

        $q = $qb->getQuery();

        try {
            $result = $q->getOneOrNullResult();

            $cpfAlreadyRegistered = !is_null($result) && isset($result['id']) ? true : false;
        } catch (\Exception $e) {
            $cpfAlreadyRegistered = false;
        }

        return $cpfAlreadyRegistered;
    }

    public function getInstructorWithEmail(?int $instructorId, ?string $email)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('i.id')
            ->from(Instructor::class, 'i')
            ->where(
                $qb->expr()->eq('i.email', ':email')
            )
            ->setParameter('email', $email);

        if ($instructorId > 0) {
            $qb->andWhere($qb->expr()->neq("i.id", ":instructorId"))
                ->setParameter("instructorId", (int)$instructorId);
        }

        $q = $qb->getQuery();

        try {
            $result = $q->getOneOrNullResult();

            $emailAlreadyRegistered = !is_null($result) && isset($result['id']) ? true : false;
        } catch (\Exception $e) {
            $emailAlreadyRegistered = false;
        }

        return $emailAlreadyRegistered;
    }

    public function getDrivingSchoolExists(int $drivingSchoolId)
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

    public function getInstructorExists(int $instructorId)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('i.id')
            ->from(Instructor::class, 'i')
            ->where(
                $qb->expr()->eq('i.id', ':instructorId')
            )
            ->setParameter('instructorId', $instructorId);

        $q = $qb->getQuery();

        try {
            $result = $q->getOneOrNullResult();

            $instructorIdExist = !is_null($result) && isset($result['id']) ? true : false;
        } catch (\Exception $e) {
            $instructorIdExist = false;
        }

        return $instructorIdExist;
    }

    public function getAllInstructorsFromDrivingSchool(int|null $drivingSchoolId)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('i.id, i.name, i.email, i.phone, i.cpf, i.birth_date, i.category')
            ->from(Instructor::class, 'i')
            ->where(
                $qb->expr()->eq('i.drivingSchool', ':drivingSchool')
            )
            ->setParameter('drivingSchool', $drivingSchoolId);

        $q = $qb->getQuery();

        try {
            $result = $q->getResult();
        } catch (\Exception $e) {
            $result = [];
        }

        return $result;
    }

    public function getStudantById(int $instructorId)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('i.id, i.name, i.email, i.phone, i.cpf, i.birth_date, i.category')
            ->from(Instructor::class, 'i')
            ->where(
                $qb->expr()->eq('i.id', ':instructorId')
            )
            ->setParameter('instructorId', $instructorId);

        $q = $qb->getQuery();

        try {
            $result = $q->getSingleResult();
        } catch (\Exception $e) {
            $result = [];
        }

        return $result;
    }
}