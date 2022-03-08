<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Developer;
use App\Entity\Project;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ProjectController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/project', name: 'app_project_index')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $project = new Project();

        $form = $this->createFormBuilder($project)
            ->add('name', TextType::class)
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'name'
            ])
            ->add('developers', EntityType::class, [
                'class' => Developer::class,
                'choice_label' => 'lastName',
                'multiple' => true
            ])
            ->add('save', SubmitType::class, ['label' => 'Create Project'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $project = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('app_project_index');
        }

        return $this->renderForm('pages/project/index.html.twig', [
            'form' => $form,
            'projectsList' => $doctrine->getRepository(Project::class)->findAll()
        ]);
    }
}
