<?php

namespace App\Controller;

use App\Entity\Ebook;
use App\Repository\EbookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EbookController extends AbstractController
{
    // /**
    //  * @Route("/ebook", name="ebook")
    //  */
    // public function index(EbookRepository $repository): Response
    // {
    //     $ebook = $repository->findAll();

    //     return $this->render('ebook/index.html.twig', [
    //         'ebook' => $ebook,
    //     ]);
    // }

    /**
     * @Route("/ebook/{category}", name="ebookPerCategory")
     *
     * @param mixed $category
     */
    public function findPerCategory(EbookRepository $repository, $category): Response
    {
        $ebook = $repository->findByCategory($category);

        return $this->render('ebook/index.html.twig', [
            'ebook' => $ebook,
            'category' => $category,
            // 'name' => intval($category),
        ]);
    }

    /**
     * @Route("/ebook/displayEbook/{id}", name="displayEbook")
     */
    public function display(Ebook $ebook): Response
    {
        return $this->render('ebook/displayEbook.html.twig', [
            'ebook' => $ebook,
        ]);
    }
}
