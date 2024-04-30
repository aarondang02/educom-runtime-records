<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\RecordService;

class HomepageController extends AbstractController
{
    private $recordService;

    public function __construct(RecordService $recordService)
    {
        $this->recordService = $recordService;
    }

    #[Route('/homepage', name: 'app_homepage')]
    public function index(): Response
    {
        return $this->render('homepage/index.html.twig', [
            "featuredRecord" => $this->recordService->getFeaturedRecord(),
            "recordList" => $this->recordService->getAllRecords(),
        ]);
    }
}
