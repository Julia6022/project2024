<?php

/**
 * Security controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\ChangeNicknameType;
use App\Form\Type\ChangePasswordType;
use App\Form\Type\RegistrationType;
use App\Service\UserServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * SecurityController class.
 */
class SecurityController extends AbstractController
{
    /**
     * Constructor.
     *
     * @param UserServiceInterface        $userService    User interface
     * @param TranslatorInterface         $translator     Translator interface
     * @param UserPasswordHasherInterface $passwordHasher User password interface
     */
    public function __construct(private readonly UserServiceInterface $userService, private readonly TranslatorInterface $translator, private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    /**
     * Login.
     *
     * @param AuthenticationUtils $authenticationUtils Authentication
     *
     * @return Response Response
     */
    #[\Symfony\Component\Routing\Attribute\Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser() instanceof \Symfony\Component\Security\Core\User\UserInterface) {
            return $this->redirectToRoute('question_index');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * Logout.
     *
     * @return void Void
     */
    #[\Symfony\Component\Routing\Attribute\Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * Register.
     *
     * @param Request                     $request        Request
     * @param UserPasswordHasherInterface $passwordHasher User password interface
     *
     * @return Response Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(
            RegistrationType::class,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('app_register'),
            ]
        );

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $form->getData();
            $user = new User();
            $user->setEmail($data['email']);
            $user->setNickname($data['nickname']);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $data['password']
                )
            );

            $this->userService->save($user);

            $this->addFlash(
                'success',
                $this->translator->trans('message.success')
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/registration.html.twig', [
            'controller_name' => 'RegistrationController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Change nickname action.
     *
     * @param Request                     $request        Request
     * @param User                        $user           User entity
     * @param UserPasswordHasherInterface $passwordHasher User password interface
     *
     * @return Response Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/{id}/change_nickname', name: 'app_change_nickname', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function changeNickname(Request $request, User $user, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(
            ChangeNicknameType::class,
            $user,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('app_change_nickname', ['id' => $user->getId()]),
            ]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($hashedPassword);
            $this->userService->save($user);

            $this->addFlash(
                'success',
                $this->translator->trans('message.success')
            );

            return $this->redirectToRoute('question_index');
        }

        return $this->render(
            'security/edit.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Change password action.
     *
     * @param Request                     $request        Request
     * @param User                        $user           User entity
     * @param UserPasswordHasherInterface $passwordHasher User password interface
     *
     * @return Response Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/{id}/change_password', name: 'app_change_password', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function changePassword(Request $request, User $user, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(
            ChangePasswordType::class,
            $user,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('app_change_password', ['id' => $user->getId()]),
            ]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($hashedPassword);
            $this->userService->save($user);

            $this->addFlash(
                'success',
                $this->translator->trans('message.success')
            );

            return $this->redirectToRoute('question_index');
        }

        return $this->render(
            'security/edit.html.twig',
            ['form' => $form->createView()]
        );
    }
}
