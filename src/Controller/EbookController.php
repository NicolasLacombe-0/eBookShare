<?php

namespace App\Controller;

use App\Entity\Ebook;
use App\Repository\CategoryRepository;
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
     * @Route("/ebook/displayEbook/{id}", name="displayEbook")
     */
    public function display(Ebook $ebook): Response
    {
        return $this->render('ebook/displayEbook.html.twig', [
            'ebook' => $ebook,
        ]);
    }
}
