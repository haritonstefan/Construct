<?php

namespace Construct\AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $entities = array_merge(
            $this->getDoctrine()->getManager()->getRepository('AppBundle:Product')->findAll(),
            $this->getDoctrine()->getManager()->getRepository('AppBundle:Service')->findAll()
        );

        return $this->render('@App/Main/index.html.twig', [
            'entities' => $entities
        ]);
    }

    /**
     * @Route("/about", name="about")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function aboutAction()
    {
        return $this->render('@App/Main/about.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction()
    {
        return $this->render('@App/Main/contact.html.twig');
    }
}
