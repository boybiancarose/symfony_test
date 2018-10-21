<?php
// src/AppBundle/Controller/ProductController.php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Product;


class ProductController extends Controller
{
    /**
     * @Route("/product/create", name="product_create")
     */
    public function createAction()
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: createAction(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(19.99);
        $product->setDescription('Ergonomic and stylish!');

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }

    /**
     * @Route("/product/edit", name="product_edit", methods={"GET","HEAD"})
     */
    // if you have multiple entity managers, use the registry to fetch them
    public function editAction()
    {
        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $otherEntityManager = $doctrine->getManager('other_connection');
    }


    /**
     * @Route("/product/{productId}", name="product_display", requirements={"productId"="\d+"})
     */
    public function showAction($productId)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($productId);

        if (!$product) {
            /*throw $this->createNotFoundException(
                'No product found for id '.$productId
            );*/
            return $this->render('product/noproduct.html.twig', array(
                'product' => $product,
            ));
        }

        // ... do something, like pass the $product object into a template
        return $this->render('product/product.html.twig', array(
            'product' => $product,
        ));
    }

}