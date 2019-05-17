<?php
namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\OrderProduct;
use App\Repository\ProductCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class OrderController extends AbstractController
{
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/products", name="order.index")
     *
     * @return Response
     */
    public function index(ProductCategoryRepository $productCategoryRepository):Response
    {

        if($this->session->get('order') !== null)
        {
            $order =  $this->session->get('order');
            //$this->session->invalidate();
        }
        else
        {
            $order = new Order();
            $this->session->set('order', $order);
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
    public function show()
    {
        return new Response('confirmation de commande');
    }

    /**
     * @Route("/products/{id}", name="order.add")
     */
    public function addProduct(Product $product, Request $request, UploaderHelper $helper)
    {
        if($request->isXmlHttpRequest())
        {
            $order =  $this->session->get('order');

            foreach($order->getOrderProducts() as $key => $item)
            {
                if($item->getProduct()->getId() === $product->getId())
                {
                    if($request->getMethod() == "POST")
                    {
                        $quantity = $request->request->get('quantity');
                        $order->getOrderProductByIndex($key)->setQuantity($quantity);
                    
                        $this->session->set('order', $order);

                        return $this->json([
                            'totalPrice' => $order->totalPrice()
                        ], 200);
                    }
                    else if($request->getMethod() == "DELETE")
                    {
                        $order->removeOrderProduct($item);
                        $this->session->set('order', $order);

                        return $this->json([
                            'totalPrice' => $order->totalPrice()
                        ], 200);
                    }
                    else
                    {
                        $quantity = $item->getQuantity() + 1;
                        $order->getOrderProductByIndex($key)->setQuantity($quantity);
                    
                        $this->session->set('order', $order);
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

            $this->session->set('order', $order);
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