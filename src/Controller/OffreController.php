<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Offre;
use App\Form\OffreType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @Route("/offre")
 */
class OffreController extends AbstractController
{
    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request)
    {
        $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $offre=$form->getData();
            VarDumper::dump($offre);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offre);

            $entityManager->flush();
            return $this->redirect($this->generateUrl('listOffre'));

        }
        return $this->render('offre/new.html.twig', array('form' => $form->createView(),));
    }
    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit($id, Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Offre::class);
        $editOffre = $repository->find($id);
        // Equivalent du SELECT * where id=(paramètre) //
        $form = $this->createForm(OffreType::class, $editOffre);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() && $request->isMethod('POST'))
        {
            $editOffre = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirect($this->generateUrl('listOffre'));
        }
        return $this->render('offre/edit.html.twig', ['editOffre' => $editOffre, 'form' => $form->createView()]);
    }
    /**
     * @Route("/delete/{id}", name="delete", requirements={"id"="\d+"})
     */
    public function delete($id)
    {
        $suppBD = $this->getDoctrine()->getManager();

        $suppOffre = $suppBD->getRepository(Offre::class)->find($id);

        $suppBD->remove($suppOffre);
        // Execution
        $suppBD->flush();
        return $this->redirectToRoute('listOffre');
    }
    /**
     * @Route("/list", name="listOffre")
     */
    public function list()
    {
        // Appel de Doctrine
        $display = $this->getDoctrine()->getManager();

        $repository = $display->getRepository(Offre::class);
        $listOffre = $repository->findAll();

        return $this->render('offre/list.html.twig', array('lesOffre'=>$listOffre));
    }
}
