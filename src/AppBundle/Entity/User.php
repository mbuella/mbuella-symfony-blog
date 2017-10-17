<?php

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User implements UserInterface
{
	/** Properties **/
	
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
	
    /**
     * @ORM\Column(type="string", unique=true)
     */
	private $email;
	
	/** Methods **/
	
    public function getUsername()
    {
		return $this->email;
    }
	
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getRoles()
    {
		return ['ROLE_USER'];
    }

    public function getPassword()
    {
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }
}