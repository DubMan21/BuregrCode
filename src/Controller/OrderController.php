<?php
namespace App\Controller;

use App\Entity\TheOrder;
use App\Entity\Product;
use App\Form\OrderType;
use App\Entity\OrderProduct;
use App\Repository\ProductCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\TheOrderRepository;

class OrderController extends AbstractController
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var TheOrderRepository
     */
    private $theOrderRepository;

    public function __construct(SessionInterface $session, ObjectManager $manager, TheOrderRepository $theOrderRepository)
    {
        $this->session = $session;
        $this->manager = $manager;
        $this->theOrderRepository = $theOrderRepository;
    }

    /**
     * @Route("/products", name="order.index")
     *
     * @return Response
     */
    public function index(ProductCategoryRepository $productCategoryRepository):Response
    {
        if($this->session->get('order') === null)
        {
            $order = new TheOrder();
            $order->setCreated_at(new \Datetime());
            $this->manager->persist($order);
            $this->manager->flush();
            $this->session->set('order', $order->getId());
        }
        else
        {
            $order = $this->theOrderRepository->find($this->session->get('order'));
        }

        $categories = $productCategoryRepository->findAll();

        return $this->render('order/index.html.twig', [
            'categories' => $categories,
            'order' => $order
        ]);
    }

    /**
     * @Route("/order", name="order.show")
     *
     * @return Response
     */
    public function show(Request $request)
    {
        $order = $this->theOrderRepository->find($this->session->get('order'));

        if($order->getOrderProducts()->isEmpty())
        {
            return $this->redirectToRoute('order.index');
        }

        $form = $this->createForm(OrderType::class, $order);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $order->setOrderAt(new \Datetime());

            $this->manager->persist($order);
            $this->manager->flush();

            $this->get('session')->set('order', null);
            return $this->redirectToRoute('order.index');
        }

        return $this->render('order/show.html.twig', [
            'order' => $order,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/products/{id}", name="order.add")
     */
    public function addProduct(Product $product, Request $request, UploaderHelper $helper)
    {
        if($request->isXmlHttpRequest())
        {
            $order = $this->theOrderRepository->find($this->session->get('order'));

            foreach($order->getOrderProducts() as $key => $item)
            {
                if($item->getProduct()->getId() === $product->getId())
                {
                    if($request->getMethod() == "POST")
                    {
                        $quantity = $request->request->get('quantity');
                        $order->getOrderProductByIndex($key)->setQuantity($quantity);

                        $order->setCreated_at(new \Datetime());
                        $this->manager->persist($order);
                        $this->manager->flush();

                        return $this->json([
                            'totalPrice' => $order->totalPrice()
                        ], 200);
                    }
                    else if($request->getMethod() == "DELETE")
                    {
                        $order->removeOrderProduct($item);

                        $order->setCreated_at(new \Datetime());
                        $this->manager->persist($order);
                        $this->manager->flush();

                        return $this->json([
                            'totalPrice' => $order->totalPrice()
                        ], 200);
                    }
                    else
                    {
                        $quantity = $item->getQuantity() + 1;
                        $order->getOrderProductByIndex($key)->setQuantity($quantity);

                        $order->setCreated_at(new \Datetime());
                        $this->manager->persist($order);
                        $this->manager->flush();
                    
                        return $this->json([
                            'quantity' => $quantity,
                            'totalPrice' => $order->totalPrice(),
                            'id' => $item->getProduct()->getId()
                        ], 200);
                    } 
                }
            }
            
            $orderProduct = new OrderProduct();

            $orderProduct->setQuantity(1);
            $orderProduct->setProduct($product);

            $order->addOrderProduct($orderProduct);
            $order->setCreated_at(new \Datetime());
            $this->manager->persist($order);
            $this->manager->flush();

            return $this->json([
                'quantity' => $orderProduct->getQuantity(),
                'totalPrice' => $order->totalPrice(),
                'id' => $orderProduct->getProduct()->getId(),
                'name' => $orderProduct->getProduct()->getName(),
                'path' => $helper->asset($orderProduct->getProduct(), 'imageFile')
            ], 201);
        }
        return;
    }
}