<?php

namespace AppBundle\Doctrine;

use AppBundle\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class HashPasswordListener implements EventSubscriber
{
	private $passwordEncoder;
	
	public function __construct(UserPasswordEncoder $passwordEncoder)
	{
		$this->passwordEncoder = $passwordEncoder;
	}
	 
	public function getSubscribedEvents()
	{
		 return ['prePersist', 'preUpdate'];
	}
	
	public function prePersist(LifecycleEventArgs $args)
	{
		$user = $args->getEntity();
		if($user instanceof User) {
			$this->encodePassword($user);
		}
	}
	
	public function preUpdate(LifecycleEventArgs $args)
	{
		$user = $args->getEntity();
		if($user instanceof User) {
			$this->encodePassword($user);
			
			// necessary to force the update to see the change
			$em = $args->getEntityManager();
			$meta = $em->getClassMetadata(get_class($user));
			$em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $user);
		}
		
	}
	
	private function encodePassword(User $user)
	{
		if($user->getPlainPassword()) {
			$encoded = $this->passwordEncoder->encodePassword(
				$user,
				$user->getPlainPassword()
			);
			
			$user->setPassword($encoded);
		}
	}
}