<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use App\Repository\UserRepository;
use App\Repository\SourceRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;



class Source extends AbstractController
{
    private SourceRepository $SourceRepository;
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager, SourceRepository $SourceRepository, UserRepository $UserRepository)
    {
        $this->SourceRepository = $SourceRepository;
        $this->entityManager = $entityManager;
        $this->UserRepository = $UserRepository;
    }
    function Show_Source($userId){
        $Sources = $this->SourceRepository->SourceListOfUser($userId);
        return $this->render("Source.html.twig",["Sources" => $Sources,"userId" => $userId]);
    }

    function Create_Source_page($userId){
        return $this->render("CreateSource.html.twig",['userId' => $userId]);
    }
    function Create_Source($userId)
    {
        $SourceName = $_POST["SourceName"];
        $this->SourceRepository->CreateSource($userId,$SourceName);
        return $this->redirectToRoute("SourceManager",["userId" => $userId]);
    }

    function Delete_Source($SourceId,$userId){
        $this->SourceRepository->DeleteSource($SourceId);
        return $this->redirectToRoute("SourceManager",["userId" => $userId]);
    }

} 

