<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Form\AnnoncesType;
use App\Repository\AnnoncesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/annonces")
 */
class AnnoncesController extends AbstractController
{
    /**
     * @Route("/", name="annonces_index", methods={"GET"})
     */
    public function index(AnnoncesRepository $annoncesRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $annoncesRepository->findAll(),
            $request->query->getInt('page',1),6
        );
        return $this->render('annonces/index.html.twig', [
            'annoncespagination' =>$pagination ,
        ]);
    }

    /**
     * @Route("/new", name="annonces_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $annonce = new Annonces();
        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['photo_annonce']->getData();

            if(!is_string($file)){
                $fileName = $file->getClientOriginalName();
                $file->move(
                    $this->getParameter('images_directory', $fileName)
                );
                $annonce->setPhotoAnnonce($fileName);
                $this->addFlash('success','Votre photo est enregistrée!');
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('annonces_index');

        }else{
            $this->addFlash('danger','Une erreur est survenue lors du téléchargement de la photo!');
        }

        return $this->render('annonces/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="annonces_show", methods={"GET"})
     */
    public function show(Annonces $annonce): Response
    {
        return $this->render('annonces/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="annonces_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Annonces $annonce): Response
    {
        $img = $annonce->getPhotoAnnonce();

        $formEditAnnonce = $this->createForm(AnnoncesType::class, $annonce);
        $formEditAnnonce->handleRequest($request);

        if ($formEditAnnonce->isSubmitted() && $formEditAnnonce->isValid()) {

            $file = $formEditAnnonce['photo_annonce']->getData();

            if(!is_string($file)){
                $fileName = $file->getClientOriginalName();
                $file->move(
                    $this->getParameter('images_directory', $fileName)
                );
                $annonce->setPhotoAnnonce($fileName);
                $this->addFlash('success', 'Votre photo à bien modifiée !');
            }else{
                $annonce->setPhotoAnnonce($img);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('annonces_index');
        }

        return $this->render('annonces/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $formEditAnnonce->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="annonces_delete", methods={"POST"})
     */
    public function delete(Request $request, Annonces $annonce): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('annonces_index');
    }
}
