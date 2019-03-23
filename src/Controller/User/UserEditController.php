<?php
/**
 * Created by PhpStorm.
 * User: halex
 * Date: 23.03.19
 * Time: 20:42
 */

namespace App\Controller\User;


use App\Entity\User;
use App\Form\UserEditFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UserEditController extends AbstractController
{
    public function index(Request $request, User $user)
    {
        
        $form = $this->createForm(UserEditFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('index');
        }
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
