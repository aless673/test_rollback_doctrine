<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/create-user', name: 'create-user')]
    public function homepage()
    {
        $user = new User();
        $user->setLastName('Doe');
        $user->setFirstName('John');
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new Response();
    }
}
