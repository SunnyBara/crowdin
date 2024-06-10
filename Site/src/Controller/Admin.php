<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Entity\Language;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use App\Repository\UserRepository;
use App\Repository\LanguageRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;



class Admin extends AbstractController
{
    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;
    private LanguageRepository $languageRepository;
    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository,UserPasswordHasherInterface $passwordHasher,LanguageRepository $languageRepository)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->languageRepository = $languageRepository;
        
    }
    public function addlanguage(): Response
    {
        $languageName = $_POST['language_name'];
        $language = new Language();
        $language->setLanguageName($languageName);
        $this->entityManager->persist($language);
        $this->entityManager->flush();
        $this->addFlash('success', "$languageName added to data");
        return $this->redirectToRoute('LanguagePage');
    }
    public function deletelanguage(int $id): Response
    {
        $language = $this->languageRepository->find($id);
        $languageName = $language->getLanguageName();
        $this->languageRepository->delById($id);
        $this->addFlash('success', "$languageName deleted from data");
        return $this->redirectToRoute('LanguagePage');
    }
    

    public function showlanguage(): Response
    {
        $languages = $this->languageRepository->findAll();
        return $this->render('Language.html.twig',[ "languages" => $languages]); 
    }
    public function userpagemanagement(): Response
    {
        return $this->render('admin.html.twig'); 
    }
    public function searchUser(): Response
    {
        $user = new User();
        $login = $_POST['user_login'];
        $user = $this->userRepository->findOneByUsername($login);
        if ($user) {
            
            return $this->render('admin.html.twig', [
                'user' => $user,
            ]);
        }else {
            $this->addFlash("error","Login not found in database");
        }

        return $this->redirectToRoute('UserManagement');
    }
    public function updateUserState(): Response
    {
        $state = $_POST["user_state"];
        $is_product_owner = ($_POST["is_product_owner"]);
        $is_translator = ($_POST["is_translator"]);
        $login = $_POST["user_login"];
        $update_user = $this->userRepository->findOneByUsername($login);
        $update_user->setUserState($state);
        $update_user->setIsTranslator($is_translator);
        $update_user->setIsProductOwner($is_product_owner);
        $this->entityManager->persist($update_user);
        $this->entityManager->flush();
        $message = "User $login updated";
        return $this->render('admin.html.twig' , [  'user' => $update_user, 'message' => $message]); 
    }

    public function deleteUser($userId):Response
    {
        $this->userRepository->deleteUser($userId);
        $this->addFlash("success","user $userId deleted from data");
        return $this->redirectToRoute("UserManagement");
    }
} 

