<?php
// src/AppBundle/Controller/LuckyTwigController.php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class LuckyTwigController extends Controller
{
    /**
     * @Route("/lucky/twig/number")
     */
    public function numberAction()
    {
        $number = random_int(0, 100);

        return $this->render('lucky/number.html.twig', array(
            'number' => $number,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR
        ));
    }


    /**
     * @Route("/lucky/twig/page/{page}", name="number_list", requirements={"page"="\d+"})
     */
    public function listAction($page)
    {
        return $this->render('lucky/number.html.twig', array(
            'number' => $page,
        ));
    }


    /**
     * @Route("/lucky/twig/page/required/{page}", name="number_required_list", requirements={"page"="\d+"})
     */
    public function requiredAction($page = 1)
    {
        return $this->render('lucky/number.html.twig', array(
            'number' => $page,
        ));
    }


    /**
     * @Route(
     *     "/lucky/twig/advanced/{_locale}/{year}/{passvalue}.{_format}",
     *     defaults={"_format": "html"},
     *     requirements={
     *         "_locale": "en|fr",
     *         "_format": "html|rss",
     *         "year": "\d+"
     *     }
     * )
     */
    public function advancedAction($_locale, $year, $passvalue)
    {
        /**
        lucky/twig/advanced/en/2010/my-post
        lucky/twig/advanced/fr/2010/my-post.rss
        lucky/twig/advanced/en/2013/my-latest-post.html
         */
        return $this->render('lucky/number.html.twig', array(
            'number' => $passvalue,
        ));
    }


    /**
     * @Route("/lucky/twig/pass/{passvalue}", name="pass_list")
     */
    public function showAction($passvalue)
    {
        return $this->render('lucky/number.html.twig', array(
            'number' => $passvalue,
        ));
    }


    /**
     * Route using routing.yml
     */
    public function displayAction($passvalue)
    {
        return $this->render('lucky/number.html.twig', array(
            'number' => $passvalue,
        ));
    }


    /**
     * Route using routing.yml
     */
    public function defaultAction()
    {
        return $this->render('lucky/display.html.twig');
    }


}