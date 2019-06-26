<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $msg = new Contact();
        $form = $this->createForm(ContactType::class, $msg);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){

          

           $manager->persist($msg);
           $manager->flush();

           $this->addFlash('notice', 'Votre message a été envoyé');

           return $this->redirectToRoute('contact');
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
