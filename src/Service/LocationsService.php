<?php


namespace App\Service;

use App\Repository\LocationsRepository;

class LocationsService
{
    private $locationsRepository;

    public function __construct(LocationsRepository $locationsRepository)
    {
        $this->locationsRepository = $locationsRepository;
    }

    public function calcOrderShipping(int $id, float $order_price): int
    {
        $location = $this->locationsRepository->findByPk($id);
        if($order_price >= LocationsRepository::MIN_FREE_SHIPPING_PRICE)
        {
            return 0;
        }else
        {
            return $location->getShippingCost();
        }
    }
}