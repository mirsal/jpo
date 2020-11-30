<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepartmentController extends AbstractController
{
    /**
     * @Route("/les-departements", name="departments")
     */
    public function index(array $departments): Response
    {
        return $this->render('department/index.html.twig', [
            'departments' => $departments,
        ]);
    }

    /**
     * @Route("/les-departements/{slug}", name="department")
     */
    public function item(array $departments, string $slug): Response
    {
        if (!isset($departments[$slug])) {
            throw $this->createNotFoundException('Le département %s n\'existe pas', $slug);
        }

        return $this->render('department/item.html.twig', [
            'departments' => $departments,
            'department' => $departments[$slug],
        ]);
    }
}
