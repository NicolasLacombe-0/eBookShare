<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EbookController extends AbstractController
{
    /**
     * @Route("/ebook", name="ebook")
     */
    public function index(): Response
    {
        return $this->render('ebook/index.html.twig', [
            'controller_name' => 'EbookController',
        ]);
    }

    /**
     * @Route("/ebook/displayEbook", name="displayEbook")
     */
    public function display(): Response
    {
        return $this->render('ebook/displayEbook.html.twig', [
            'controller_name' => 'EbookController',
        ]);
    }
}
