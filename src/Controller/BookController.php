<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController // controller for the home page & nav
{
    /**
     * @Route("/", name="book")
     */
    public function index(CategoryRepository $repository): Response
    {
        $category = $repository->findAll();

        return $this->render('book/index.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/account", name="account")
     */
    public function profile(): Response
    {
        return $this->render('book/profile.html.twig');
    }
}
