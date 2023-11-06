<?php

namespace App\Service\Classroom\Storage;

use App\Entity\Classroom;
use App\Entity\DrivingSchool;
use App\Entity\Instructor;
use App\Entity\Student;
use App\Entity\Vehicle;
use App\Service\Classroom\Entity\ClassroomEntity;
use Doctrine\ORM\EntityManagerInterface;

class ClassroomStorage implements ClassroomStorageInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function saveClassroom(ClassroomEntity $classroomEntity)
    {
        $drivingSchoolRepository = $this->entityManager->getRepository(DrivingSchool::class);
        $drivingSchool = $drivingSchoolRepository->find($classroomEntity->getDrivingSchoolId());

        $instructorRepository = $this->entityManager->getRepository(Instructor::class);
        $instructor = $instructorRepository->find($classroomEntity->getInstructorId());

        $studentRepository = $this->entityManager->getRepository(Student::class);
        $student = $studentRepository->find($classroomEntity->getStudentId());

        $vehicleRepository = $this->entityManager->getRepository(Vehicle::class);
        $vehicle = $vehicleRepository->find($classroomEntity->getVehicleId());

        $classroom = new Classroom();

        $classroom->setDrivingSchool($drivingSchool)
            ->setDate(new \DateTime($classroomEntity->getDate()))
            ->setInstructor($instructor)->setStudent($student)->setVehicle($vehicle);

        $this->entityManager->persist($classroom);
        $this->entityManager->flush();
    }

    public function updateClassroom(ClassroomEntity $classroomEntity)
    {
        $classroomRepository = $this->entityManager->getRepository(Classroom::class);
        $classroom = $classroomRepository->find($classroomEntity->getId());

        $instructorRepository = $this->entityManager->getRepository(Instructor::class);
        $instructor = $instructorRepository->find($classroomEntity->getInstructorId());

        $studentRepository = $this->entityManager->getRepository(Student::class);
        $student = $studentRepository->find($classroomEntity->getStudentId());

        $vehicleRepository = $this->entityManager->getRepository(Vehicle::class);
        $vehicle = $vehicleRepository->find($classroomEntity->getVehicleId());

        $classroom->setDate(new \DateTime($classroomEntity->getDate()))
            ->setInstructor($instructor)->setStudent($student)->setVehicle($vehicle);

        $this->entityManager->persist($classroom);
        $this->entityManager->flush();
    }

    public function deleteClassroom(ClassroomEntity $classroomEntity)
    {
        $classroomRepository = $this->entityManager->getRepository(Classroom::class);
        $classroom = $classroomRepository->find($classroomEntity->getId());

        $this->entityManager->remove($classroom);
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

    public function getInstructorExists(?int $instructorId)
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

    public function getStudantExists(?int $studentId)
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

    public function getClassroomExists(?int $classroomId)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('c.id')
            ->from(Classroom::class, 'c')
            ->where(
                $qb->expr()->eq('c.id', ':classroomId')
            )
            ->setParameter('classroomId', $classroomId);

        $q = $qb->getQuery();

        try {
            $result = $q->getOneOrNullResult();

            $classroomExist = !is_null($result) && isset($result['id']) ? true : false;
        } catch (\Exception $e) {
            $classroomExist = false;
        }

        return $classroomExist;
    }

    public function getAllClassroomFromDrivingSchool(?int $drivingSchoolId)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('c.id, c.date, s.name as student_name, i.name instructor_name, v.model as vehicle_model')
            ->from(Classroom::class, 'c')
            ->innerJoin(Student::class, 's', 'WITH', 'c.student = s.id')
            ->innerJoin(Instructor::class, 'i', 'WITH', 'c.instructor = i.id')
            ->innerJoin(Vehicle::class, 'v', 'WITH', 'c.vehicle = v.id')
            ->where(
                $qb->expr()->eq('c.drivingSchool', ':drivingSchool')
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

    public function getClassroomById(?int $classroomId)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('c.id, c.date, s.name as student_name, i.name instructor_name, v.model as vehicle_model')
            ->from(Classroom::class, 'c')
            ->innerJoin(Student::class, 's', 'WITH', 'c.student = s.id')
            ->innerJoin(Instructor::class, 'i', 'WITH', 'c.instructor = i.id')
            ->innerJoin(Vehicle::class, 'v', 'WITH', 'c.vehicle = v.id')
            ->where(
                $qb->expr()->eq('c.id', ':classroomId')
            )
            ->setParameter('classroomId', $classroomId);

        $q = $qb->getQuery();

        try {
            $result = $q->getSingleResult();
        } catch (\Exception $e) {
            $result = [];
        }

        return $result;
    }
}