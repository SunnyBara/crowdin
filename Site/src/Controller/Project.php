<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;



class Project extends AbstractController
{
    private ProjectRepository $ProjectRepository;
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager, ProjectRepository $ProjectRepository, UserRepository $UserRepository)
    {
        $this->ProjectRepository = $ProjectRepository;
        $this->entityManager = $entityManager;
        $this->UserRepository = $UserRepository;
    }
    function Show_project($userId){
        $projects = $this->ProjectRepository->ProjectListOfUser($userId);
        return $this->render("project.html.twig",["projects" => $projects,"userId" => $userId]);
    }

    function Create_project_page($userId){
        return $this->render("Createproject.html.twig",['userId' => $userId]);
    }
    function Create_project($userId)
    {
        $projectName = $_POST["projectName"];
        $this->ProjectRepository->CreateProject($userId,$projectName);
        return $this->redirectToRoute("ProjectManager",["userId" => $userId]);
    }

    function Delete_project($projectId,$userId){
        $this->ProjectRepository->DeleteProject($projectId);
        return $this->redirectToRoute("ProjectManager",["userId" => $userId]);
    }
} 

