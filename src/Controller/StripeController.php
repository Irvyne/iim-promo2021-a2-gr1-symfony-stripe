<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StripeController extends Controller
{
    /**
     * @Route("/", name="stripe")
     */
    public function index()
    {
        return $this->render('stripe.html.twig');
    }

    /**
     * @Route("/charge", name="charge")
     */
    public function charge(Request $request)
    {
        $token = $request->request->get('stripeToken');

        \Stripe\Stripe::setApiKey($this->getParameter('stripe_sk'));

        $charge = \Stripe\Charge::create([
            "amount"      => 99999,
            "currency"    => "eur",
            "source"      => $token, // obtained with Stripe.js
            "description" => "Payment 4 JohnDoe.",
        ]);

        return $this->render('stripe_charge.html.twig', [
            'charge' => $charge,
        ]);
    }
}
