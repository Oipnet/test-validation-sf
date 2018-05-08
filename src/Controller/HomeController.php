<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class HomeController
{
    /**
     * @var FormFactoryInterface
     */
    private $form;
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(FormFactoryInterface $form, Environment $twig, FlashBagInterface $flashBag, RouterInterface $router)
    {
        $this->form = $form;
        $this->twig = $twig;
        $this->flashBag = $flashBag;
        $this->router = $router;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
        $post = new Post();

        $form = $this->form->createBuilder(PostType::class, $post)->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
                $this->flashBag->add('error', "Formulaire non valide");

                return new RedirectResponse($this->router->generate('home'));
            }
            dump($form->getData());die();
        }

        return new Response($this->twig->render('home/index.html.twig', [ 'form' => $form->createView() ]));
    }
}
