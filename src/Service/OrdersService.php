<?php


namespace App\Service;

use App\Entity\Courier;
use App\Repository\CourierRepository;
use App\Repository\LocationsRepository;
use App\Repository\OrderRepository;
use App\Service\LocationsService;
use App\Entity\Order;

class OrdersService
{
    private $orderRepository;
    private $locationsService;
    private $locationsRepository;
    private $courierRepository;
    private $courierService;
    private $courier;

    public function __construct(OrderRepository $orderRepository, LocationsService $locationsService,
                                LocationsRepository $locationsRepository, CourierRepository $courierRepository,
                                CourierService $courierService)
    {
        $this->orderRepository = $orderRepository;
        $this->locationsService = $locationsService;
        $this->locationsRepository = $locationsRepository;
        $this->courierRepository = $courierRepository;
        $this->courierService = $courierService;
    }

    /**
     * @param array $content
     * @return Order
     */
    public function createOrder(array $content): Order
    {
        $shipping_price = $this->locationsService->calcOrderShipping($content['location'], $content['order_price']);
        $order_price = $content['order_price'];
        $order_price += $shipping_price;
        $locationObject = $this->locationsRepository->findByPk($content['location']);
        $order = new Order($locationObject, $order_price, $content['customer_name'], $content['phone'], $content['address'], $content['secret_word']);
        $this->orderRepository->save($order, true);
        return $order;
    }

    /**
     * @return array|null
     */
    public function getOrdersForCourier(): ?array
    {
            $location = $this->courier->getLocation();
            if(!$location){
                throw new \RuntimeException('Please set your Location');
            }
            return $this->orderRepository->getUnassignedOrders($location);
    }

    /**
     * @return Order|null
     */
    public function getAssignedOrder(): ?Order
    {
        return $this->orderRepository->getCourierAssignedOrder($this->courier->getId());
    }

    /**
     * @param string $email
     */
    public function findCourier(string $email): void
    {
        $this->courier = $this->courierService->findCourierByEmail($email);
    }

    public function assignOrder(int $order_id): ?Order
    {
        if(!$order = $this->orderRepository->findOneBy(['id'=>$order_id])){
            throw new \RuntimeException('There is no such order.');
        }
        if(in_array($order->getStatus(), [Order::STATUS_STARTED, Order::STATUS_DELIVERED]) || $order->getCourier())
        {
            throw new \RuntimeException('This order is not available, select another one.');
        }

        $order->setStatus(Order::STATUS_STARTED)->setCourier($this->courier);
        $this->orderRepository->save($order,1);
        return $order;
    }

    public function orderDelivered(int $order_id, string $secret_word): bool
    {
        if(!$order = $this->orderRepository->findOneBy(['id'=>$order_id])){
            throw new \RuntimeException('There is no such order.');
        }
        if($order->getCourier()->getId() != $this->courier->getId())
        {
            throw new \RuntimeException('You are trying to complete someone else\'s order, make sure that you specified the order correctly.');
        }

        if($order->getSecretWord() != $secret_word)
        {
            return false;
        }
        $order->setStatus(Order::STATUS_DELIVERED);
        $this->orderRepository->save($order,1);
        return true;
    }
}