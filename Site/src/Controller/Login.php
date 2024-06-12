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
use Symfony\Component\HttpFoundation\JsonResponse;



class Login extends AbstractController
{
    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;
    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository,UserPasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        
    }
    
    public function Login(): Response
    {
        return $this->render('login.html.twig');
    }

    public function Authentification(): Response | String {
        $user = new User();
        $login = $_POST["user_login"];
        $password= $_POST["user_password"];
        $user = $this->userRepository->findOneByUsername($login);
        
        if(!$user || !$this->passwordHasher->isPasswordValid($user, $password))
        {
            return new JsonResponse(['error' => 'Unidentified User'], JsonResponse::HTTP_UNAUTHORIZED);
        }else {
            return $this->render('Dashboard.html.twig', [
                'user' => $user,
            ]);
        }
        $id = 0;
        $state  = True;
        $jwt = new My_Token($id,$state);
        $token  = $jwt->get_token();
        $decoded  = My_Token :: decode_token($token);
        $response = new Response();

        $response->headers->set('Authorization', 'Bearer ' . $token);
        $response->send();
        return $this->render('Dashboard.html.twig', [
            'name' => $decoded->id,
        ]);
    }

} 


// public function postRegister() : Response
// {
//     $user_login = $_POST["user_login"];
//     $user_password = $_POST["user_password"];
//     $user_name = $_POST["user_name"];
//     $is_translator = isset($_POST["is_translator"]) ? 1 : 0;
//     $is_product_owner = isset($_POST["is_product_owner"]) ? 1 : 0;
//     print($user_login);
//     return  $this->render('login.html.twig', [
//         'name' => $user_name,
//     ]);
// }


/**
 * IMPORTANT:
 * You must specify supported algorithms for your application. See
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 * for a list of spec-compliant algorithms.
 */
// $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
// // Pass a stdClass in as the third parameter to get the decoded header values
// $decoded = JWT::decode($jwt, new Key($key, 'HS256'), $headers = new stdClass());
// print_r($headers);

/*
 NOTE: This will now be an object instead of an associative array. To get
 an associative array, you will need to cast it as such:
*/

// $decoded_array = (array) $decoded;

/**
 * You can add a leeway to account for when there is a clock skew times between
 * the signing and verifying servers. It is recommended that this leeway should
 * not be bigger than a few minutes.
 *
 * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
 */
// JWT::$leeway = 60; // $leeway in seconds
// $decoded = JWT::decode($jwt, new Key($key, 'HS256'));