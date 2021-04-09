<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
    /**
     * @Route("/", name="task_list", methods={"GET"})
     */
    public function index(TaskRepository $taskRepository)
    {
        // $tasks = $this->getDoctrine()
        //     ->getRepository(Task::class)
        //     ->findAll();

        $tasks = $taskRepository->findAll();

        return $this->render('tasks/index.html.twig', compact('tasks'));
    }

    /**
     * @Route("/task/{id}", name="task_show")
     */
    public function show($id, TaskRepository $taskRepository): Response
    {
        // $task = $this->getDoctrine()
        //     ->getRepository(Task::class)
        //     ->find($id);

        $task = $taskRepository->find($id);

        if (!$task) {
            throw $this->createNotFoundException('No Task found for id ' . $id);
        }

        return $this->render('tasks/show.html.twig', compact('task'));
    }

    /**
     * @Route("/task/store")
     */
    // public function store()
    // {
    //     $entityManager = $this->getDoctrine()->getManager();

    //     $task = new Task();
    //     $task->setName('Task 2');
    //     $task->setDescription('Task 2 Description');

    //     $entityManager->persist($task);

    //     $entityManager->flush();

    //     return new Response('Saved new task with id ' . $task->getId());
    // }
}
