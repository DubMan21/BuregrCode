<?php
namespace App\Controller\Admin;

use App\Form\CategoryType;
use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCategoryController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var ProductCategoryRepository
     */
    private $repository;

    public function __construct(ObjectManager $manager, ProductCategoryRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    /**
     * @Route("/admin/categories", name="admin.category.index")
     */
    public function index()
    {
        $categories = $this->repository->findAll();

        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/category", name="admin.category.new")
     */
    public function new(Request $request)
    {
        $category = new ProductCategory();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($category);
            $this->manager->flush();
            $this->addFlash('success', 'Catégorie créé avec succès');
            return $this->redirectToRoute('admin.category.index');
        }

        return $this->render('admin/category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/category/{id}", name="admin.category.edit", methods={"GET|POST"}, requirements={"id" = "\d+"})
     */
    public function edit(ProductCategory $category, Request $request)
    {
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($category);
            $this->manager->flush();
            $this->addFlash('success', 'Catégorie modifiée avec succès');
            return $this->redirectToRoute('admin.category.index');
        }

        return $this->render('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/category/delete", name="admin.category.delete")
     */
    public function delete(Request $request)
    {

        if($request->isXmlHttpRequest()){

            $i = 0;
            foreach($request->request->get('idArray') as $id)
            {
                $category = $this->repository->find($id);
                $this->manager->remove($category);
                $i++;
            }
            $this->manager->flush();
            
            return $this->json([], 200);
        }
        return $this->json([], 500);
    }
}