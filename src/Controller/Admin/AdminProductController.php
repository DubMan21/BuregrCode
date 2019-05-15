<?php
namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\ProductCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminProductController extends AbstractController
{

    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/admin/products", name="admin.product.index")
     */
    public function index(ProductCategoryRepository $repository)
    {
        $categories = $repository->findAll();

        return $this->render('admin/product/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/product", name="admin.product.new", methods={"GET|POST"})
     */
    public function new(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($product);
            $this->manager->flush();
            $this->addFlash('success', 'Produit créé avec succès');
            return $this->redirectToRoute('admin.product.index');
        }

        return $this->render('admin/product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/product/{id}", name="admin.product.edit", methods={"GET|POST"}, requirements={"id" = "\d+"})
     */
    public function edit(Product $product, Request $request)
    {
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($product);
            $this->manager->flush();
            $this->addFlash('success', 'Produit modifié avec succès');
            return $this->redirectToRoute('admin.product.index');
        }

        return $this->render('admin/product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/product/delete", name="admin.product.delete")
     */
    public function delete(Request $request, ProductRepository $repository)
    {
        if($request->isXmlHttpRequest()){

            $i = 0;
            foreach($request->request->get('idArray') as $id)
            {
                $product = $repository->find($id);
                $this->manager->remove($product);
                $i++;
            }
            $this->manager->flush();
            
            return $this->json([], 200);
        }
        return $this->json([], 500);
    }
}