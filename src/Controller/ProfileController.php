<?php


namespace App\Controller;

use Symfony\Component\Form\FormTypeInterface;
use App\Entity\User;
use App\Entity\Users;
use App\Form\EditProfileType;
use App\Form\UserPasswordType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use EditPasswordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\User\UserPasswordAuthenticatedUserInterface; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;


#[Route('/profil', name: 'profile_')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'Profil de l\'utilisateur',
        ]);
    }

    // #[Route('/modifier', name: 'edit_')]
    // public function edit(): Response
    // {
    //     return $this->render('profile/modifInfo.html.twig', [
    //         'controller_name' => 'modif de l\'utilisateur',
    //     ]);
    // }
    
    /**
     * Ce controller nous permet de changer les données du profil utilisateur.
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return void
     */
    #[Route("/modifier", name: 'modifier_profil', methods: ['GET', 'POST'])]
    public function editerProfil(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($hasher->isPasswordValid($user, $form->getData()->getPassword())){
                $user = $form->getData();
                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'Super! Votre profil est à jour!');
                return $this->redirectToRoute('profile_index');
            }else{
                $this->addFlash('warning', 'le mot de passe est incorrect');
                return $this->redirectToRoute('profile_index');
                
            }

           
        }

        return $this->render('profile/modifInfo.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route("/motdepasse", name: 'motdepasse', methods: ['GET', 'POST'])]
   
    public function editPassword(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $em): Response {

        $user = $this->getUser();
        $form = $this->createForm(EditPasswordType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if($hasher->isPasswordValid($user, $form->getData()['plainPassword'])){
                $user->setPassword(
                    $hasher->hashPassword($user, 
                    $form->getData()['newPassword'])
                );

                
                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'Le mot de passe a été modifié!');
                return $this->redirectToRoute('profile_index');
            }else{
                $this->addFlash('danger', 'le mot de passe est incorrect');
                
                
            }
        }
        return $this->render('profile/modifMDP.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
