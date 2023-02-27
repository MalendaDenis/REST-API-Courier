<?php


namespace App\Service;


use App\Entity\Courier;
use App\Repository\CourierRepository;

class CourierService
{
    private $courierRepository;

    public function __construct(CourierRepository $courierRepository)
    {

        $this->courierRepository = $courierRepository;
    }

    public function findCourierByEmail(string $email): ?Courier
    {
        return $this->courierRepository->findOneBy(['email'=>$email]);
    }

}