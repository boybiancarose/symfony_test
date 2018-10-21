<?php
// src/AppBundle/Controller/FormTwigController.php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class FormTwigController extends Controller
{
    /**
     * @Route("/form/twig")
     */
    public function newAction(Request $request)
    {
        // createFormBuilder is a shortcut to get the "form factory"
        // and then call "createBuilder()" on it

        $defaults = array(
            'dueDate' => new \DateTime('tomorrow'),
        );


        //($defaults, , array('action' => '/search','method' => 'GET'))
        $form = $this->createFormBuilder($defaults)
            ->add('task', TextType::class, array(
                'constraints' => new NotBlank(),
            ))
            ->add('dueDate', DateType::class, array(
                'constraints' => array(
                    new NotBlank(),
                    new Type(\DateTime::class),
                )
            ))
            ->getForm();


        // Form submitted
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // ... perform some action, such as saving the data to the database

            return $this->redirectToRoute('api_display');
        }

        return $this->render('form/form.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}