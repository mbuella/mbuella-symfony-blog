<?php
namespace AppBundle\Controller;

use AppBundle\Form\UserRegistrationForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request)
    {
		$form = $this->createForm(UserRegistrationForm::class);
		
		$form->handleRequest($request);
		
		if ($form->isValid()) {
			 /** @var User $user */
			$user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
			
            // $this->addFlash('success', 'Welcome '.$user->getEmail());
            $this->addFlash('success', 'You have successfully registered in the system. Please use your credentials now.');
            
			return $this->redirectToRoute('homepage');
		}
		
		return $this->render('AppBundle:User:register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}