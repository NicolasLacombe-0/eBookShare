<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Ebook;
use App\Form\CommentType;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\EbookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class EbookController extends AbstractController
{
    /**
     * @Route("/ebook", name="ebook")
     */
    public function index(EbookRepository $repository): Response
    {
        $ebook = $repository->findAll();

        return $this->render('ebook/index.html.twig', [
            'ebook' => $ebook,
        ]);
    }

    /**
     * @Route("/ebook/{category}", name="ebookPerCategory")
     *
     * @param mixed $category
     */
    public function findPerCategory(EbookRepository $repository, $category, CategoryRepository $categoryRepository): Response
    {
        $ebook = $repository->findByCategory($category);
        $name = $categoryRepository->findOneBy([   //----------- name a new variable to get category.name (now name.name) out of a "for" revering to the database
            'id' => $category,
        ]);

        return $this->render('ebook/index.html.twig', [
            'ebook' => $ebook,
            'category' => $category,
            'name' => $name,
        ]);
    }

    /**
     * @Route("/ebook/displayEbook/{id}", name="displayEbook",methods="GET")
     */
    public function display(Ebook $ebook, CommentRepository $commentRepository): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $comment = $commentRepository->findBy([
            'ebook' => $ebook,
        ]);

        return $this->render('ebook/displayEbook.html.twig', [
            'ebook' => $ebook,
            'comment' => $comment,
            'commentForm' => $form->createView(),
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////////

    /**
     * @Route("/ebook/displayEbook/{id}", name="comment_add",methods="POST")
     *
     * @param mixed $ebook
     */
    public function addComment(Ebook $ebook, Comment $comment = null, Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $security->getUser();
            $comment->setUpdatedAt(new \DateTime())
                ->setEbook($ebook)
                ->setUser($user)
            ;

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('account');
        }
    }
}
