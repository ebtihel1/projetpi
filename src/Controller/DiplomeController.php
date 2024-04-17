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
    #[Route('/home', name: 'app_diplome')]
    public function index(): Response
    {
        return $this->render('base.html.twig', [
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

/********************************************Supprimer********************************************************** */


    #[Route('/diplome/delete/{id}', name: 'deleteDiplome')]
public function deleteDiplome(ManagerRegistry $doctrine, $id, DiplomeRepository $diplomeRepo): Response
{
    $em = $doctrine->getManager();

    $diplomeDel = $diplomeRepo->find($id);

    if ($diplomeDel) {
        $em->remove($diplomeDel);
        $em->flush();
    }

    return $this->redirectToRoute('readDiplome'); // Redirection vers la page de lecture des diplômes après suppression
}

    
  /********************************************Modifier********************************************************** */

#[Route('/editDiplome/{id}', name: 'editDiplome')]
    public function edit(Request $request, ManagerRegistry $doctrine, $id, DiplomeRepository $diplomeRepo): Response
    {
        $em = $doctrine->getManager();

        $diplome = $diplomeRepo->find($id);

        if (!$diplome) {
            throw $this->createNotFoundException('Diplome non trouvé avec l\'ID : ' . $id);
        }

        $form = $this->createForm(DiplomeType::class, $diplome);
        $form->add('Enregistrer', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('readDiplome');
        }

        return $this->render('diplome/editD.html.twig', [
            'form' => $form->createView(),
        ]);
    }
  
}
