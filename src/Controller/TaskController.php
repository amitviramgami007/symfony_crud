<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
     * @Route("/task/new", name="new_task", methods={"GET", "POST"})
     */
    public function new(Request $request)
    {
        $task = new Task();

        $form = $this->createFormBuilder($task)
            ->add('name', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('description', TextareaType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('save', SubmitType::class, ['label' => 'Save', 'attr' => ['btn btn-primary mt-3']])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $task = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash('success', 'Task Created Successfully!');
            return $this->redirectToRoute('task_list');
        }

        return $this->render('tasks/new.html.twig', ['form'=>$form->createView()]);
    }

    /**
     * @Route("/task/edit/{id}", name="edit_task", methods={"GET", "POST"})
     */
    public function edit(Request $request, TaskRepository $taskRepository, $id)
    {
        $task = $taskRepository->find($id);

        $form = $this->createFormBuilder($task)
            ->add('name', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('description', TextareaType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('save', SubmitType::class, ['label' => 'Update', 'attr' => ['btn btn-primary mt-3']])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Task Updated Successfully!');
            return $this->redirectToRoute('task_list');
        }

        return $this->render('tasks/new.html.twig', ['form'=>$form->createView()]);
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

        if (!$task) 
        {
            throw $this->createNotFoundException('No Task found for id ' . $id);
        }

        return $this->render('tasks/show.html.twig', compact('task'));
    }

    /**
     * @Route("/task/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete($id) 
    {
        $task = $this->getDoctrine()->getRepository(Task::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($task);
        $entityManager->flush();

        $this->addFlash('success', 'Task Deleted Successfully!');
        return $this->redirectToRoute('task_list');
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
