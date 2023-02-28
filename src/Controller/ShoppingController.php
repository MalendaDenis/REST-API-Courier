<?php

namespace App\Controller;

use App\Service\LocationsService;
use App\Service\OrdersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/API/shopping')]
class ShoppingController extends AbstractController
{
    private $content;

    #[Route('/price', name: 'calcShippingPrice')]
    public function calcShippingPrice(LocationsService $locationsService, Request $request): JsonResponse
    {
        $this->content = $request->getContent();
        $this->content = json_decode($this->content);
        $expected_parameters = 1;
        if(count((array) $this->content) < $expected_parameters){
            throw new \RuntimeException('Please complete all fields ');
        }
        $location_id = (int)$this->content->location_id;
        $order_price = (float)$this->content->order_price;

        return $this->json(['shipping_price' => $locationsService->calcOrderShipping($location_id, $order_price)]);
    }

    #[Route('/order', name: 'createOrder')]
    public function createOrder(OrdersService $orderService, Request $request): JsonResponse
    {
        $this->content = $request->getContent();
        $this->content = json_decode($this->content);
        $expected_parameters = 6;
        if(count((array) $this->content) < $expected_parameters){
            throw new \RuntimeException('Please complete all fields ');
        }
        $order = $orderService->createOrder((array)$this->content);
        $response = [
            'total_price' => $order->getOrderPrice(),
            'secret_word' => $order->getSecretWord(),
        ];

        return $this->json($response);
    }

}
