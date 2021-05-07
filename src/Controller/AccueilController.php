<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
    /**
     * @Route ("/panier/ajouter/{id}", name="ajouter_panier")
     */
    public function ajouterPanier(SessionInterface $session, Annonces $annonces){

        $panier = $session->get("panier",[]);
        $id = $annonces->getId();

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id]=1;
        }

        $session->set("panier", $panier);
        return $this->redirectToRoute( 'panier');
    }

    /**
     * @Route ("/panier/enlever/{id}", name="enlever_panier")
     */
    public function enleverPanier(SessionInterface $session, Annonces $annonces){

        $panier = $session->get("panier",[]);
        $id = $annonces->getId();

        if(!empty($panier[$id])){
            if($panier[$id]>1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        $session->set("panier", $panier);
        return $this->redirectToRoute( 'panier');
    }
    /**
     * @Route ("/panier/enleverproduit/{id}", name="enlever_produit")
     */
    public function enleverProduitPanier(SessionInterface $session, Annonces $annonces){

        $panier = $session->get("panier",[]);
        $id = $annonces->getId();

        if(!empty($panier[$id])){
                unset($panier[$id]);
        }

        $session->set("panier", $panier);
        return $this->redirectToRoute( 'panier');
    }

    /**
     * @Route ("/panier/vider", name="vider_panier")
     */
    public function viderPanier(SessionInterface $session){

        $session->set("panier",[]);
        
        return $this->redirectToRoute( 'panier');
    }

    /**
     * @Route ("/panier", name="panier")
     */
    public function panier(SessionInterface $session, AnnoncesRepository $annocnesRepository){

        $panier = $session->get("panier",[]);

        $dataPanier = [];
        $total = 0;

        foreach ($panier as $id => $quantite) {
            $annonce = $annocnesRepository->find($id);
            $dataPanier[] = [
                "annonce"=>$annonce,
                "quantite"=>$quantite
            ];

            $total += $annonce->getPrixAnnonce() * $quantite;
        }

        return $this->render('accueil/panier.html.twig',[
            "dataPanier"=>$dataPanier,
            "total"=>$total
        ]);

    }

}
