<?php
namespace AppBundle\Security;

use AppBundle\Form\LoginForm;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
	private $formFactory;
	private $em;
	private $router;

	public function __construct(FormFactoryInterface $formFactory, EntityManager $em, Router $router)
	{
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->router = $router;
	}
    public function getCredentials(Request $request)
    {
        $isLoginSubmit = $request->getPathInfo() == '/login' && $request->isMethod('POST');
		if(!$isLoginSubmit)
		{
			//skip auth
			return;
		}
        $form = $this->formFactory->create(LoginForm::class);
        $form->handleRequest($request);
		
		$data = $form->getData();
		
		// dump($data);die();
		
		return $data;
    }
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['_username'];
		
		return $this->em->getRepository('AppBundle:User')
            ->findOneBy(['email' => $username]);
    }
    public function checkCredentials($credentials, UserInterface $user)
    {
		// dump($user);die();
		$password = $credentials['_password'];
		
		if ($password == 'iliketurtles') {
            return true;
        }
        return false;
    }
    protected function getLoginUrl()
    {
		return $this->router->generate('security_login');
    }
    protected function getDefaultSuccessRedirectUrl()
    {
    }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
		// $targetPath = $this->getTargetPath($request->getSession(), $providerKey);
		
		// if (!$targetPath) {
             $targetPath = $this->router->generate('homepage');
        // }
 
        return new RedirectResponse($targetPath);
    }
}