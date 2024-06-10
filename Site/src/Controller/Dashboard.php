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
use App\Repository\UserLanguageRepository;
use App\Repository\LanguageRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;



class Dashboard extends AbstractController
{
    private UserLanguageRepository $UserLanguageRepository;
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;
    private LanguageRepository $languageRepository;
    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository,LanguageRepository $languageRepository,UserLanguageRepository $UserLanguageRepository )
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->languageRepository = $languageRepository;
        $this->UserLanguageRepository =  $UserLanguageRepository;
    }

    public function dashboard($userId): Response
    {
        //gestion du token pour parse le user
        //$user.finduserbyone($login)
        $user = $this->userRepository->findOneById($userId);
        return $this->render('dashboard.html.twig',['user' => $user]);
    }


    public function language_manager(int $userId) : Response
    {
        
        $languages_user =  $this->UserLanguageRepository->findAllLanguageOfUserTag($userId);
        $languages_in_db =  $this->UserLanguageRepository->findAllLanguageOfUserUntag($userId);;
        
        return($this->render('language_user_manager.html.twig', ['userId'=>$userId,'languages_user' => $languages_user,"languages_in_db" => $languages_in_db]));

    }

    public function addLanguageOfUser($userId,$languageId) : Response
    {
        $this->UserLanguageRepository->addLanguageToUser($userId,$languageId);
        return($this->redirectToRoute('LangageManager' , ['userId' => $userId]));

    }

    public function deleteLanguageOfUser($userId,$languageId) : Response
    {
        $this->UserLanguageRepository->delLanguageToUser($userId,$languageId);
        return($this->redirectToRoute('LangageManager' , ['userId' => $userId]));

    }
} 

