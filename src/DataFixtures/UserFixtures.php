<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $users = array(
            1 => array(
                'email' => 'user@takefood.com',
                'username' => 'user',
                'password' => 'user',
                'roles' => array('ROLE_USER')
            ),
            2 => array(
                'email' => 'user1@takefood.com',
                'username' => 'user1',
                'password' => 'user1',
                'roles' => array('ROLE_USER')
            ),
            3 => array(
                'email' => 'admin@takefood.com',
                'username' => 'admin',
                'password' => 'admin',
                'roles' => array('ROLE_USER', 'ROLE_ADMIN')
            )
        );

        foreach ($users as $user) {
            $newUser = new User();
            $newUser->setEmail($user['email'])
                ->setUsername($user['username'])
                ->setPassword($this->encoder->encodePassword($newUser, $user['password']))
                ->setRoles($user['roles']);


            $manager->persist($newUser);
        }

        $manager->flush();
    }
}
