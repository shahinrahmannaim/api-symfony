<?php
// src/Controller/ApiController.php

namespace App\Controller;

use App\Service\ApiServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    private $apiService;

    public function __construct(ApiServices $apiService)
    {
        $this->apiService = $apiService;
    }

    #[Route('/', name: 'meal_search')]
    public function search(Request $request): Response
    {
        $searchInput = $request->query->get('q', '');  // Get the search input from the query parameters

        $data = [];

        if ($searchInput) {
            $data = $this->apiService->fetchData('https://www.themealdb.com/api/json/v1/1/filter.php', [
                'i' => $searchInput  // Search by ingredient
            ]);
        }

        return $this->render('api/index.html.twig', [
            'meals' => $data['meals'] ?? null,
            'searchInput' => $searchInput
        ]);
    }
}
