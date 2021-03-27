<?php

namespace App\Controller;

use App\Entity\Prospect;
use App\Form\InscriptionType;
use App\Repository\ProspectRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProspectController extends AbstractController
{
    /**
     * @return Response
     * @Route ("/",name="accueil")
     */
    public function accueil(){
        return $this->render('prospect/accueil.html.twig');
    }

    /**
     * @Route("/prospect", name="prospect")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param ProspectRepository $prospectRepository
     * @return Response
     */
    public function inscription(Request $request,EntityManagerInterface $manager,ProspectRepository $prospectRepository): Response
    {
        $prospect = new Prospect();
        $form = $this->createForm(InscriptionType::class,$prospect);
        $form->handleRequest($request);
        $prospects = $prospectRepository->findAll();
        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($prospect);
            $manager->flush();
            return $this->redirectToRoute('prospect');
        }
        return $this->render('prospect/inscription.html.twig', [
                'form'=>$form->createView(),
                'prospects'=>$prospects
        ]);
    }

    /**
     * @return Response
     * @Route ("/archive",name="archive")
     */
    public function archive(){
        return $this->render('prospect/archive.html.twig');
    }

    /**
     * @param Request $request
     * @param ProspectRepository $prospectRepository
     * @return JsonResponse
     * @Route ("/recupererInscrit")
     */
    public function recupererInscrit(Request $request,ProspectRepository $prospectRepository):JsonResponse{
        $contenu = json_decode($request->getContent(),true);
        $debut = $contenu['debut'];
        $fin = $contenu['fin'];
        $listeProspect =[];
        $Debut = DateTime::createFromFormat('!d/m/Y', $debut);
        $Fin = DateTime::createFromFormat('!d/m/Y', $fin);
        $prospects = $prospectRepository->findByDate($Debut,$Fin);
        foreach ($prospects as $prospect){
            array_push($listeProspect,[
                'nom'=>$prospect->getNom(),
                'prenom'=>$prospect->getPrenom(),
                'mail'=>$prospect->getEmail(),
                'remarque'=>$prospect->getRemarque(),
                'telephone'=>$prospect->getTelephone(),
                'date'=>$prospect->getDate()->format('d/m/Y')
            ]);
        }

        $response = new JsonResponse();
        return $response->setData($listeProspect);
    }
}
