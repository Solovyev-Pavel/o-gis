<?php

/* ************************************************************************** *
 *   Copyright © 2015       Pavel Solovyev (solovyev.p.a@gmail.com)           *
 *                          Sergey Sevryukov (sevrukovs@gmail.com)            *
 *                          Alexander Afonin (acer737@yandex.ru)              *
 *                                                                            *
 *   Licensed under the Apache License, Version 2.0 (the "License");          *
 *   you may not use this file except in compliance with the License.         *
 *   You may obtain a copy of the License at                                  *
 *               http://www.apache.org/licenses/LICENSE-2.0                   *
 *                                                                            *
 *   Unless required by applicable law or agreed to in writing, software      *
 *   distributed under the License is distributed on an "AS IS" BASIS,        *
 *   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. *
 *   See the License for the specific language governing permissions and      *
 *   limitations under the License.                                           *
 * ************************************************************************** */

namespace OGIS\IndexBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Model\UserInterface;
use OGIS\IndexBundle\Entity\User;
use OGIS\IndexBundle\Entity\Role;
use OGIS\IndexBundle\Entity\Catalog;

class UserExtraFieldAssignmentListener implements EventSubscriberInterface {

		protected $entityManager;
		protected $aclProvider;
		protected $tokenStorage;

		public function __construct($entityManager, $aclProvider, $tokenStorage){
				$this->entityManager = $entityManager;
				$this->aclProvider = $aclProvider;
				$this->tokenStorage = $tokenStorage;
		}

		public static function getSubscribedEvents(){
				return array( FOSUserEvents::REGISTRATION_COMPLETED => 'onRegistrationSuccessful' );
		}

		public function onRegistrationSuccessful(UserEvent $event){
				$user = $event->getUser();

				// set user display name using username as default value
				$user->setDisplayName($user->getUsername());
				// update user role to 'proper' value and add limits to user
				$user->setRoles(array('ROLE_USER'));
				$limits = $this->entityManager->getRepository('OGIS\IndexBundle\Entity\Role')->findOneBy(array('role' => 'ROLE_USER'));
				$user->setLimits($limits);

				// create catalogs for the user
				$catalog = new Catalog();
				$catalog->addOwner($user);
				$catalog->setTitle($user->getDisplayName() . '\'s resources');
				$this->entityManager->persist($catalog);
				$this->entityManager->flush();

				// bind catalog to user
				$user->addCatalog($catalog);

				// ACL
				$objectIdentity = ObjectIdentity::fromDomainObject($catalog);
				try{
						$acl = $this->aclProvider->findAcl($objectIdentity);
				}catch (\Symfony\Component\Security\Acl\Exception\AclNotFoundException $e) {
						$acl = $this->aclProvider->createAcl($objectIdentity);
				}
				$securityIdentity = UserSecurityIdentity::fromAccount($user);
				$acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
			$this->aclProvider->updateAcl($acl);
			}
}
