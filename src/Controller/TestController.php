<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Record;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\RecordRepository;
use Doctrine\ORM\EntityManagerInterface;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $rep = $entityManager->getRepository(Record::class);
        $data = $rep->getAllRecords();
        dump($data);
        die();
    }
}
