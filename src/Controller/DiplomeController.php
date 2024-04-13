<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Diplome;
use App\Form\DiplomeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\DiplomeRepository;


class DiplomeController extends AbstractController
{
    #[Route('/diplome', name: 'app_diplome')]
    public function index(): Response
    {
        return $this->render('diplome/index.html.twig', [
            'controller_name' => 'DiplomeController',
        ]);
    }

    /**************************************Afficher********************************************************* */

    #[Route('/Diplome/read', name: 'readDiplome')]
    public function read(DiplomeRepository $diplomeRepo): Response
    {
        $diplome = $diplomeRepo->findAll();
        return $this->render('diplome/readD.html.twig', [
            'diplome' => $diplome,
        ]);
    }

    /**************************************Ajouter******************************************************************* */
    
    #[Route('/addDiplome', name: 'addDiplome')]
    public function add(Request $request, ManagerRegistry $registry): Response
    {
        $em = $registry->getManager();
    
        $diplome = new Diplome();
    
        $form = $this->createForm(DiplomeType::class, $diplome);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($diplome);
            $em->flush();
            return $this->redirectToRoute('readDiplome'); // Redirection à ajuster selon votre configuration de routes
        }
    
        // Passer directement le formulaire à la méthode render()
        return $this->render('diplome/createD.html.twig', ['form' => $form->createView()]);
    }
    
}
