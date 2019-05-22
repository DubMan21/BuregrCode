<?php
namespace App\Notification;

use App\Entity\TheOrder;
use Twig\Environment;

class OrderConfirmationNotification
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(TheOrder $order)
    {
        $message = (new \Swift_Message('Burger Code : Confirmation de commande'))
            ->setFrom('noreply@burgercode.com')
            ->setTo($order->getEmail())
            ->setReplyTo('help@burgercode.com')
            ->setBody($this->renderer->render('emails/orderConfirmation.html.twig', [
                'order' => $order
            ]), 'text/html');
        
            $this->mailer->send($message);
    }
}