<?php
/**
 * Home controller.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController.
 */
#[\Symfony\Component\Routing\Attribute\Route('/home')]
class HomeController extends AbstractController
{
    /**
     * Index action.
     *
     * @return Response HTTP response
     */
    #[\Symfony\Component\Routing\Attribute\Route(name: 'home_index')]
    public function index(): Response
    {
        return $this->render(
            'home/index.html.twig'
        );
    }
}
