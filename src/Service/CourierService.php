<?php


namespace App\Service;


use App\Entity\Courier;
use App\Repository\CourierRepository;
use App\Repository\LocationsRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CourierService
{
    private $courierRepository;
    private $locationsRepository;
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher, CourierRepository $courierRepository, LocationsRepository $locationsRepository)
    {

        $this->courierRepository = $courierRepository;
        $this->locationsRepository = $locationsRepository;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function findCourierByEmail(string $email): ?Courier
    {
        return $this->courierRepository->findOneBy(['email'=>$email]);
    }

    public function createCourier(\stdClass $content): void
    {
        if($this->findCourierByEmail((string)$content->email)){
            throw new \RuntimeException('This email already exists, choose another one.');
        }
        $location = $this->locationsRepository->findByPk((int)$content->location);
        $courier = new Courier();
        $courier->setEmail((string)$content->email);
        $courier->setName((string)$content->name);
        $courier->setPassword($this->userPasswordHasher->hashPassword($courier, (string)$content->plainPassword));
        $courier->setLocation($location);

        $this->courierRepository->save($courier, true);
    }

}