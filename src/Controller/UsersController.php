<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    // public function users(Connection $connection): Response
    // {
    //     $users = $connection->fetchAll('SELECT * FROM user');

    //     return $this->json($users);
    // }

    /**
     * @Route("/users/create", name="user_create")
     */
    // public function create(Connection $connection, Request $request)
    // {
    //     $connection->insert('user', ['username' => $request->get('username')]);

    //     return $this->json([
    //         'success' => true,
    //         'message' => sprintf('Create %s successfully!', $request->request->get('username')),
    //     ]);
    // }

    /**
     * @Route("/users", name="users")
     */
    public function users(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->json(array_map(function (User $user) {
            return
                [
                    'username' => $user->getUsername(),
                ];
        }, $users));
    }

    /**
     * @Route("/users/create/{username}", name="users_create")
     */
    public function create(EntityManagerInterface $em, Request $request)
    {
        $user = new User();
        // dd($request->get('username'));
        $user->setUsername($request->get('username'));


        $em->persist($user);
        $em->flush();

        return $this->json([
            'success' => true,
            'message' => sprintf('Create %s successfully!', $request->get('username')),
        ]);
    }
}
