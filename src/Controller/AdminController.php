<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Ebook;
use App\Entity\User;
use App\Form\CommentType;
use App\Form\EbookType;
use App\Form\UserType;
use App\Repository\CommentRepository;
use App\Repository\EbookRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_ADMIN")
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

    /**
     * @Route("/admin/editComment/{id}", name="adminCommentEdit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editingComment(Comment $comment, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setEbook($comment->getEbook())
                ->setUser($comment->getUser())
                ->setUpdatedAt(new \DateTime())
            ;

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('admin')
            ;
        }

        return $this->render(
            'comment/editComment.html.twig',
            [
                'comment' => $comment,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/admin/{id}", name="adminCommentDeletion", methods="delete")
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminCommentDeletion(Comment $comment, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('SUP'.$comment->getId(), $request->get('_token'))) {
            $entityManager->remove($comment);
            $entityManager->flush();
            // $this->addFlash('success', 'Successfully deleted');

            return $this->redirectToRoute('admin');
        }
    }

    /**
     * @Route("/admin/addEbook", name="ebookAdd")
     * @Route("/admin/editEbook/{id}", name="ebookEdit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editingEbook(Ebook $ebook = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$ebook) {
            $ebook = new Ebook();
        }
        $form = $this->createForm(EbookType::class, $ebook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ebook);
            $entityManager->flush();

            return $this->redirectToRoute('admin')
            ;
        }

        return $this->render(
            'admin/editEbook.html.twig',
            [
                'ebook' => $ebook,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/admin/{id}}", name="ebookDeletion", methods="delete")
     * @IsGranted("ROLE_ADMIN")
     */
    public function ebookDeletion(Ebook $ebook, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('SUP'.$ebook->getId(), $request->get('_token'))) {
            $entityManager->remove($ebook);
            $entityManager->flush();
            $this->addFlash('success', 'Successfully deleted');

            return $this->redirectToRoute('admin');
        }
    }

    /**
     * @Route("/admin/editUser/{id}", name="userEdit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editingUser(User $user, Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $roles = $user->getRoles();
        if ($form->isSubmitted() && $form->isValid()) {
            $passwordCrypto = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($passwordCrypto);
            $user->setRoles($roles)
            ;

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('admin')
            ;
        }

        return $this->render(
            'admin/editUser.html.twig',
            [
                'user' => $user,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/admin/{id}", name="userDeletion", methods="delete")
     * @IsGranted("ROLE_ADMIN")
     */
    public function userDeletion(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('SUP'.$user->getId(), $request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success', 'Successfully deleted');

            return $this->redirectToRoute('admin');
        }
    }
}
