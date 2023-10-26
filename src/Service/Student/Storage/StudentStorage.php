<?php

namespace App\Service\Student\Storage;

use App\Entity\DrivingSchool;
use App\Entity\Student;
use App\Service\Student\Entity\StudentEntity;
use Doctrine\ORM\EntityManagerInterface;

class StudentStorage implements StudentStorageInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function saveStudent(StudentEntity $studentEntity)
    {
        $drivingSchoolRepository = $this->entityManager->getRepository(DrivingSchool::class);
        $drivingSchool = $drivingSchoolRepository->find($studentEntity->getDrivingSchoolId());

        $student = new Student();
        $student->setDrivingSchool($drivingSchool)
            ->setName($studentEntity->getName())
            ->setPhone($studentEntity->getPhone())
            ->setCpf($studentEntity->getCpf())
            ->setBirthDate(new \DateTime($studentEntity->getBirthDate()));

        $this->entityManager->persist($student);
        $this->entityManager->flush();
    }

    public function updateStudant(StudentEntity $studentEntity)
    {
        $studantRepository = $this->entityManager->getRepository(Student::class);
        $studant = $studantRepository->find($studentEntity->getId());

        $studant->setName($studentEntity->getName())
            ->setPhone($studentEntity->getPhone())
            ->setCpf($studentEntity->getCpf())
            ->setBirthDate(new \DateTime($studentEntity->getBirthDate()));

        $this->entityManager->persist($studant);
        $this->entityManager->flush();
    }

    public function deleteStudant(StudentEntity $studentEntity)
    {
        $studantRepository = $this->entityManager->getRepository(Student::class);
        $studant = $studantRepository->find($studentEntity->getId());

        $this->entityManager->remove($studant);
        $this->entityManager->flush();
    }

    public function getStudentWithCpf(int|null $studentId, string $cpf)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('s.id')
            ->from(Student::class, 's')
            ->where(
                $qb->expr()->eq('s.cpf', ':cpf')
            )
            ->setParameter('cpf', $cpf);

        if ($studentId > 0) {
            $qb->andWhere($qb->expr()->neq("s.id", ":idStudent"))
                ->setParameter("idStudent", (int)$studentId);
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

    public function getStudantExists(int $studentId)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('s.id')
            ->from(Student::class, 's')
            ->where(
                $qb->expr()->eq('s.id', ':studentId')
            )
            ->setParameter('studentId', $studentId);

        $q = $qb->getQuery();

        try {
            $result = $q->getOneOrNullResult();

            $drivingSchoolExist = !is_null($result) && isset($result['id']) ? true : false;
        } catch (\Exception $e) {
            $drivingSchoolExist = false;
        }

        return $drivingSchoolExist;
    }

    public function getAllStudantsFromDrivingSchool(int|null $drivingSchoolId)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('s.id, s.name, s.phone, s.cpf, s.birth_date')
            ->from(Student::class, 's')
            ->where(
                $qb->expr()->eq('s.drivingSchool', ':drivingSchool')
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

    public function getStudantById(int|null $studentId)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('s.id, s.name, s.phone, s.cpf, s.birth_date')
            ->from(Student::class, 's')
            ->where(
                $qb->expr()->eq('s.id', ':studentId')
            )
            ->setParameter('studentId', $studentId);

        $q = $qb->getQuery();

        try {
            $result = $q->getSingleResult();
        } catch (\Exception $e) {
            $result = [];
        }

        return $result;
    }
}