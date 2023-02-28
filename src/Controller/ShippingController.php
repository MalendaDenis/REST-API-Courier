<?php

namespace App\Controller;

use App\Service\OrdersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


#[IsGranted('ROLE_USER')]
#[Route('/API/shipping')]
class ShippingController extends AbstractController
{
    private $jwtManager;
    private $tokenStorageInterface;
    private $decodedJwtToken;
    private $content;

    public function __construct(TokenStorageInterface $tokenStorageInterface, JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
        $this->decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());
    }

    #[Route('/orders', name: 'getLocationOrders', methods: ['GET'])]
    public function locationOrders(OrdersService $ordersService,Request $request): JsonResponse
    {
        $ordersService->findCourier($this->decodedJwtToken['username']);
        if($ordersService->getAssignedOrder()){
            throw new \RuntimeException('First, finish the order already assigned to you');
        }
        $response = [
            'message'=>'Choose one of the orders',
        ];
        $orders = $ordersService->getOrdersForCourier();
        if(!$orders){
            $response['message'] = 'There are no orders at the moment';
        }
        foreach ($orders as $order){
            $response['orders'][] = [
                'id'=>$order->getId(),
                'name'=>$order->getCustomerName(),
                'phone' =>$order->getPhone(),
                'address'=>$order->getAddress(),
                'price'=>$order->getOrderPrice(),
            ];
        }
        return $this->json($response);
    }
    #[Route('/started', name: 'assignOrder', methods: ['PUT'])]
    public function assignOrder(OrdersService $ordersService,Request $request): JsonResponse
    {
        $ordersService->findCourier($this->decodedJwtToken['username']);
        $this->content = $request->getContent();
        $this->content = json_decode($this->content);
        $expected_parameters = 1;
        if(count((array)$this->content) < $expected_parameters){
            throw new \RuntimeException('Please complete all fields.');
        }
        if($ordersService->getAssignedOrder()){
            throw new \RuntimeException('First, finish the order already assigned to you.');
        }

        if($order = $ordersService->assignOrder($this->content->order))
        {
            $response = [
                'message'=>'The order is selected, now you can deliver it.',
                'order' => [
                    'id'=>$order->getId(),
                    'name'=>$order->getCustomerName(),
                    'phone' =>$order->getPhone(),
                    'address'=>$order->getAddress(),
                    'price'=>$order->getOrderPrice(),
                ]
            ];
        }else{
            $response = [
                'message'=>'An error occurred, the order was not assigned.',
            ];
        }

        return $this->json($response);
    }

    #[Route('/delivered', name: 'orderDelivered', methods: ['PUT'])]
    public function orderDelivered(OrdersService $ordersService,Request $request): JsonResponse
    {
        $ordersService->findCourier($this->decodedJwtToken['username']);
        $this->content = $request->getContent();
        $this->content = json_decode($this->content);
        $expected_parameters = 2;
        if(count((array)$this->content) < $expected_parameters){
            throw new \RuntimeException('Please complete all fields.');
        }

        if($ordersService->orderDelivered($this->content->order, $this->content->secret_word))
        {
            $response = [
                'message'=>'The order was delivered successfully, you can choose another one.',
            ];
        }else{
            $response = [
                'message'=>'The secret word is incorrect, check it with the customer and enter it again',
            ];
        }
        return $this->json($response);
    }
}
