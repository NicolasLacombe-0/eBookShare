<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/account/{id}", name="account", methods="GET")
     * @IsGranted("ROLE_USER")
     */
    public function profile(CommentRepository $commentRepository): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $comment = $commentRepository->findBy([
            'user' => $user,
        ]);

        return $this->render('book/profile.html.twig', [
            'user' => $user,
            'comment' => $comment,
        ]);
    }

    /**
     * @Route("/account/{id}", name="commentDeletion", methods="delete")
     */
    public function deletion(Comment $comment, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('SUP'.$comment->getId(), $request->get('_token'))) {
            $entityManager->remove($comment);
            $entityManager->flush();
            $this->addFlash('success', 'Successfully deleted');

            return $this->redirectToRoute('account', ['id' => $comment->getUser()->getId()]);
        }
    }
}
