<?php
namespace App\Controller\Admin;

use App\Repository\UserAccountRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminUserController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var ProductCategoryRepository
     */
    private $repository;

    public function __construct(ObjectManager $manager, UserAccountRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    /**
     * @Route("/admin/user", name="admin.user.index")
     */
    public function index()
    {
        $users = $this->repository->findAll();

        return $this->render('admin/user/index.html.twig', [
            'users' => $users
        ]);
    }
}