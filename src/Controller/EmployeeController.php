<?php

namespace App\Controller;

use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends AbstractController
{
    /**
     * @Route("/employee", name="employee")
     */
    public function index(): Response
    {
        return $this->render('employee/index.html.twig', [
            'controller_name' => 'EmployeeController',
        ]);
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function deptWisedata(EmployeeRepository $employeeRepository)
    {
        $results = $employeeRepository->getDepartmentWiseclassEmployee();

        dd($results);
    }
}
