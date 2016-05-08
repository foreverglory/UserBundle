<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\UserBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of Group
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class UserExtension extends \Twig_Extension
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('user', array($this, 'getUser')),
        );
    }

    public function getUser($id = null, $field = null)
    {
        if ($id) {
            $manager = $this->getUserManager();
            $user = $manager->findUserBy(['id' => $id]);
        } else {
            $token = $this->container->get('security.token_storage')->getToken();
            $user = $token->getUser();
        }
        if ($user && $field) {
            return $user->$field;
        }
        return $user;
    }

    protected function getUserManager()
    {
        return $this->container->get('glory_user.user_manager');
    }

    public function getName()
    {
        return 'glory_user.user_extension';
    }

}
