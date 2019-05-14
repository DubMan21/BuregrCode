<?php
namespace App\Controller;

use App\Repository\ProductCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    /**
     * @Route("/products", name="order.index")
     *
     * @return Response
     */
    public function index(ProductCategoryRepository $productCategoryRepository):Response
    {
        $categories = $productCategoryRepository->findAll();

        return $this->render('order/index.html.twig', [
            'categories' => $categories
        ]);
    }
}