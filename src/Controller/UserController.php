<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Form\ResetPassType;
use App\Entity\PasswordUpdate;
use App\Form\PasswordUpdateType;
use App\Repository\ActuRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user/log", name="user_log")
     */
    public function login(AuthenticationUtils $outils)
    {
        $erreur = $outils->getLastAuthenticationError();
        $identifiant = $outils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'erreur' => $erreur !== null,
            'identifiant' => $identifiant
        ]);
        return $this->redirectToRoute('homepage');
    }

    /**
     * permet la deconnexion
     *
     * @Route("/user/logout", name="user_logout")
     * @return void
     */
    public function logout()
    {
    }

    /**
     * modifprofil
     * @Route("/user/info", name="user_info")
     * 
     * @IsGranted("ROLE_USER")
     * 
     *
     * @return Response
     */
    public function profile(Request $request, EntityManagerInterface $manager, ActuRepository $repo_actu, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();

        $form_info = $this->createForm(AccountType::class, $user);

        $form_info->handleRequest($request);

        if ($form_info->isSubmitted() && $form_info->isValid()) {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Modification du profil enregistré"
            );
        }

        $passwordUpdate = new PasswordUpdate();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //verifié le oldpassword
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getHash())) {
                //gérer l'erreur
                $form->get('oldPassword')->addError(new FormError("le mot de passe ne correspond pas a votre mot de passe actuel"));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);

                $user->setHash($hash);

                $manager->persist($user);
                $manager->flush($user);

                $this->addFlash(
                    'success',
                    "Votre mot de passe a bien été modifié !"
                );
            }
        }

        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('user/modifInfo.html.twig', [
            'form_info' => $form_info->createView(),
            'form' => $form->createView(),
            'side_actu' => $actus
        ]);
    }

    /**
     * @Route("/user/oubli-pass", name="app_forgotten_password")
     *
     * @return void
     */
    public function forgottenPass(Request $req, UserRepository $repo_user, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator, EntityManagerInterface $manager)
    {
        //on créé le form
        $form = $this->createForm(ResetPassType::class);
        //on traite le form
        $form->handleRequest($req);
        // si le form est valid
        if ($form->isSubmitted() && $form->isValid()) {
            //on récupère les données
            $donnees = $form->getData();

            //on chercher si un user a cette email
            $user = $repo_user->findOneByEmail($donnees['email']);
            //si le user n'existe pas
            if (!$user) {
                //envoie flash message
                $this->addFlash('danger', 'Cette adresse n\'existe pas');
                return $this->redirectToRoute('user_log');
            }

            //si user on génère un token
            $token = $tokenGenerator->generateToken();

            try {
                $user->setresetToken($token);
                $manager->persist($user);
                $manager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', 'une erreur est survenue:' . $e->getMessage());
                return $this->redirectToRoute('user_log');
            }

            //on génère l'url de reinitialisation du MP
            $url = $this->generateUrl(
                'app_reset_password',
                ['token' => $token],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            //envoie message
            $message = (new \Swift_Message('Mot de passe oublié'))
                ->setFrom('no-reply@ac-sologne.fr')
                ->setTo($user->getEmail())
                ->setBody(
                    "<p>Bonjour,</p><p>Une demande de réinitialisation de mot de passe a été effectuée pour votre compte sur ac-soslogne.fr. Veuillez cliquer sur le lien suivant pour le réinitialiser : <a href='$url'>cliquer ici</a>  </p>",
                    'text/html'
                );

            //on envoie le mail
            $mailer->send($message);

            //on créé le message flash
            $this->addFlash('message', 'Un e-mail de réinitialisation de mot de passe vous a été envoyé');

            return $this->redirectToRoute('user_log');
        }
        // on envoie vers la page de demande de l'email
        return $this->render('user/forgotten_password.html.twig', ['emailForm' => $form->createView()]);
    }

    /**
     * reset le password
     *
     * @Route("/reset-pass/{token}", name="app_reset_password")
     * 
     * @return void
     */
    public function resetPassword($token, Request $req, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager)
    {
        //on chercher le user avec le token fourni
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token' => $token]);

        if (!$user) {
            $this->addFlash('danger', 'Token inconnu');
            return $this->redirectToRoute('user_log');
        }
        //si le form est envoyé en post
        if ($req->isMethod('post')) {
            // dd();
            //on supprime le token
            $user->setresetToken(null);
            //on chiffre le mot de passe
            $hash = $encoder->encodePassword($user, $req->request->get('password'));
            $user->setHash($hash);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('message', 'Mot de passe modifié avec succès');

            return $this->redirectToRoute('user_log');
        } else {
            return $this->render('user/reset_password.html.twig', ['token' => $token]);
        }
    }
}
