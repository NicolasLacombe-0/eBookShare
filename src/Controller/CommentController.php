<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment", name="comment")
     */
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    /**
     * @Route("/comment/editComment/{id}", name="commentEdit")
     */
    public function editingComment(Comment $comment, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setUpdatedAt(new \DateTime())
            ;

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('account');
        }

        return $this->render(
            'comment/editComment.html.twig',
            [
                'comment' => $comment,
                'form' => $form->createView(),
            ]
        );
    }

    // /**
    //  * @Route("/admin/fruit/{id}", name="commentDeletion", methods="delete")
    //  */
    // public function suppression(Fruit $fruit, Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('SUP'.$fruit->getId(), $request->get('_token'))) {
    //         $entityManager->remove($fruit);
    //         $entityManager->flush();
    //         $this->addFlash('success', 'Suppression réussie');

    //         return $this->redirectToRoute('admin_fruit');
    //     }
    //
        // return $this->render(
        //     'admin/admin_fruit/adminFruit.html.twig',
        //     [
        //         'fruit' => $fruit,
        //     ]
        // );
    // }
}
