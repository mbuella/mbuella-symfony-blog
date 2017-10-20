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
     * The encoded password
     *
     * @ORM\Column(type="string")
     */
    private $password;
	
    /**
     * A non-persisted field that's used to create the encoded password.
     *
     * @var string
     */
    private $plainPassword;
	
    /**
     * @ORM\Column(type="string", unique=true)
     */
	private $email;
	
	/**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

	
	/** Methods **/
	
    public function getUsername()
    {
		return $this->email;
    }
	
    public function setEmail($email)
    {
        $this->email = $email;
    }

	public function getEmail()
	{
		return $this->email;
	}
	
    public function getRoles()
    {
		// return ['ROLE_USER'];
		$roles = $this->roles;
        
		if (!in_array('ROLE_USER', $roles)) {
            $roles[] = 'ROLE_USER';
        }
		
		return $roles;
    }
	
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    public function getPassword()
    {
		return $this->password;
    }
	
    public function setPassword($password)
    {
		$this->password = $password;
    }
	
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
	
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
		
        // forces the object to look "dirty" to Doctrine. Avoids
        // Doctrine *not* saving this entity, if only plainPassword changes
        $this->password = null;
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
		  $this->plainPassword = null;
    }
}