<?php
namespace AppBundle\Security;

use AppBundle\Form\LoginForm;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
	private $formFactory;

	public function __construct(FormFactoryInterface $formFactory)
	{
        $this->formFactory = $formFactory;
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
    }
    public function checkCredentials($credentials, UserInterface $user)
    {
    }
    protected function getLoginUrl()
    {
    }
    protected function getDefaultSuccessRedirectUrl()
    {
    }
}