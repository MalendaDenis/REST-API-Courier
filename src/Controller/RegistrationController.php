<?php

namespace App\Controller;

use App\Service\CourierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private $content;

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, CourierService $courierService): JsonResponse
    {
        $this->content = $request->getContent();
        $this->content = json_decode($this->content);
        $expected_parameters = 4;
        if(count((array)$this->content) < $expected_parameters){
            throw new \RuntimeException('Please complete all fields.');
        }
        $courierService->createCourier($this->content);

        $response = [
            'message'=>'The account has been created successfully, you can now log in and get started ',
        ];
        return $this->json($response);
    }
}
