<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Record;
use App\Service\RecordService;
use App\Service\CartItemService;

#[Route('/recordpage')]
class RecordpageController extends AbstractController
{
    private $recordService;
    private $cartItemService;

    public function __construct(RecordService $recordService, CartItemService $cartItemService)
    {
        $this->recordService = $recordService;
        $this->cartItemService = $cartItemService;
    }

    #[Route('/{id}', name: 'app_recordpage', methods: ['GET'])]
    public function index(Record $record): Response
    {
        
        return $this->render('recordpage/index.html.twig', [
            'record' => $record,
            "featuredRecord" => $this->recordService->getFeaturedRecord(),
            "recordList" => $this->recordService->getAllRecords(),
        ]);
    }
}
