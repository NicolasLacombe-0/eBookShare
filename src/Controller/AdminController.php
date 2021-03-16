<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\EbookRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(EbookRepository $ebookRepository, UserRepository $userRepository, CommentRepository $commentRepository): Response
    {
        $comment = $commentRepository->findAll();
        $user = $userRepository->findAll();
        $ebook = $ebookRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'comment' => $comment,
            'user' => $user,
            'ebook' => $ebook,
        ]);
    }
}
