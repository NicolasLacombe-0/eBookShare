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

    // /**
    //  * @Route("/comment/addingComment", name="comment_add")
    //  *
    //  * @param mixed $ebook
    //  */
    // public function modification(Comment $comment = null, Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     if (!$comment) {
    //         $comment = new Comment();
    //     }
    //     $form = $this->createForm(CommentType::class, $comment);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $edit = null !== $comment->getId();
    //         $comment->setUpdatedAt(new \DateTime())
    //             ->setEbook($ebook)
    //         ;

    //         $entityManager->persist($comment);
    //         $entityManager->flush();
    //         $this->addFlash('success', ($edit) ? 'Edited comment successfully' : 'Comment was added');

    //         return $this->redirectToRoute('displayEbook', ['id' => $ebook->getId()]);
    //     }

    //     return $this->render(
    //         'comment/addingComment.html.twig',
    //         [
    //             'comment' => $comment,
    //             'form' => $form->createView(),
    //             'isModification' => null !== $comment->getId(),
    //         ]
    //     );
    // }
}
