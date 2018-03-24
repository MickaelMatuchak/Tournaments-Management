<?php

namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * TODO peut certainement être amélioré... surtout la partie inscription
 */
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $username = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $username,
            'error' => $error,
            'register_error' => false
        ));
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request)
    {
        $error = '';

        if ($request->getMethod() === 'POST') {
            $user = new User();

            $entityManager = $this->getDoctrine()->getManager();

            $username = $request->request->get('_register-username');
            $password = $request->request->get('_register-password');
            $confirmPassword = $request->request->get('_register-confirm-password');

            $isExist = true;

            if (!empty($username)) {
                $isExist = $entityManager->getRepository('App:User')->findOneBy(['username' => $username]);
            }

            if ($isExist !== null || $password !== $confirmPassword) {
                $error = 'Invalid information';
            } else {
                $user->setUsername($username);
                $user->setPassword(password_hash($password, PASSWORD_BCRYPT));

                $entityManager->persist($user);
                $entityManager->flush();


                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->get('security.token_storage')->setToken($token);
                $this->get('session')->set('_security_main', serialize($token));

                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('security/login.html.twig', array(
            'register_error' => $error,
            'error' => false,
            'last_username' => ''
        ));
    }
}