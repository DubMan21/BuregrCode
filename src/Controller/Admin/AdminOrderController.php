<?php
namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\TheOrderRepository;
use App\Entity\TheOrder;

class AdminOrderController extends AbstractController
{
    /**
     * @var TheOrderRepository
     */
    private $theOrderRepository;

    public function __construct(TheOrderRepository $theOrderRepository)
    {
        $this->theOrderRepository = $theOrderRepository;
    }

    /**
     * @Route("/admin/order", name="admin.order.index")
     */
    public function index()
    {
        $orders = $this->theOrderRepository->findAllValid();

        return $this->render('admin/order/index.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/admin/order/{id}", name="admin.order.show")
     */
    public function show(TheOrder $order)
    {
        return $this->render('admin/order/show.html.twig', [
            'order' => $order
        ]);
    }
}
