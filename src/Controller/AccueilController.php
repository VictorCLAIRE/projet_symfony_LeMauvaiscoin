<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Entity\Categories;
use App\Entity\Regions;
use App\Form\RechercheType;
use App\Repository\AnnoncesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(Request $request, AnnoncesRepository $annoncesRepository): Response
    {
        $annonces= new Annonces();
        $prixMin = '';
        $prixMax = '';
        $prix = $annonces->getPrixAnnonce();
        $cat = $annonces->getCategorieAnnonce();
        $region = $annonces->getRegionAnnonce();

        $formRecherche = $this->createFormBuilder()
            ->add('categorie_annonce',EntityType::class,[
                'class'=>Categories::class,
                'choice_label'=>'name_categorie',
                'required'=>false
            ])
            ->add('region_annonce',EntityType::class,[
                'class'=>Regions::class,
                'choice_label'=>'name_region',
                'required'=>false
            ])
            ->add('prixMin',NumberType::class,[
                'label'=>'PrixMin',
                'required'=> false
            ])
            ->add('prixMax',NumberType::class,[
                'label'=>'PrixMax',
                'required'=> false
            ])
            ->add('Recherche', SubmitType::class,[
                'label'=>'Rechercher'
            ])
            ->getForm();

        $formRecherche->handleRequest($request);

        if($request->isMethod('POST') && $formRecherche->isSubmitted() && $formRecherche->isValid()){
            $data = $formRecherche->getData();
            $prixMin = $data['prixMin'];
            $prixMax = $data['prixMax'];
            $cat = $data['categorie_annonce'];
            $region = $data['region_annonce'];
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name'=>'AnnonceController',
            'formRecherche' => $formRecherche->createView(),
            'annoncesrecherches'=> $annoncesRepository->AnnoncesRecherche($prixMin, $prixMax,$prix, $cat, $region )

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
