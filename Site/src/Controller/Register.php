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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class Register extends AbstractController
{

    private $entityManager;
    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository,UserPasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        
    }
    


    public function getRegister(): Response
    {
        return $this->render('register.html.twig');
    }

    public function postRegister2( ) : Response
    {

        $is_translator = isset($_POST["is_translator"]) ? 1 : 0;
        $is_product_owner = isset($_POST["is_product_owner"]) ? 1 : 0;
        $login = $_POST["user_login"];
        $user = $this->userRepository->findOneByUsername($login);
        if (!$user) {
            $new_user = new User();
            $new_user->setUserLogin($login);
            $hashed_password = $this->passwordHasher->hashPassword($new_user, $_POST["user_password"]);
            $new_user->setUserPassword($hashed_password);
            $new_user->setUserName($_POST["user_name"]);
            $new_user->setUserLogin($_POST["user_login"]);
            $new_user->setIsTranslator($is_translator);
            $new_user->setIsProductOwner($is_product_owner);
            $this->entityManager->persist($new_user);
            $this->entityManager->flush();
            return  $this->render('login.html.twig', ['name' => $hashed_password]);
        }else {
            return $this->render('register.html.twig',['error' => 'Login Already Used']);
        }

    }
    public function Retest(): Response 
    {

        $number = $this->test();
        return $this->render('luckynumber.html.twig', [
            'numbers' => $number,
        ]);
    }
} 