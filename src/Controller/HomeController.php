<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

    public function __construct(FormFactoryInterface $form, Environment $twig)
    {
        $this->form = $form;
        $this->twig = $twig;
    }

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $post = new Post();

        $form = $this->form->createBuilder(PostType::class, $post)->getForm();

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form);die();
        }

        return new Response($this->twig->render('home/index.html.twig', [ 'form' => $form->createView() ]));
    }
}
