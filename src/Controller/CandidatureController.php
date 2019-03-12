<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Candidature;
use App\Form\CandidatureType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @Route("/candidature")
 */
class CandidatureController extends AbstractController
{
    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request)
    {
        $candidature = new Candidature();
        $form = $this->createForm(CandidatureType::class, $candidature);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $candidature=$form->getData();
            VarDumper::dump($candidature);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidature);

            $entityManager->flush();
            return $this->redirect($this->generateUrl('listCand'));

        }
        return $this->render('candidature/new.html.twig', array('form' => $form->createView(),));
    }
    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit($id, Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Candidature::class);
        $editCandidature = $repository->find($id);
        // Equivalent du SELECT * where id=(paramètre) //
        $form = $this->createForm(ContactType::class, $editCandidature);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() && $request->isMethod('POST'))
        {
            $editCandidature = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirect($this->generateUrl('listCand'));
        }
        return $this->render('contact/edit.html.twig', ['editCandidature' => $editCandidature, 'form' => $form->createView()]);
    }
    /**
     * @Route("/delete/{id}", name="delete", requirements={"id"="\d+"})
     */
    public function delete($id)
    {
        $suppBD = $this->getDoctrine()->getManager();

        $suppCandidature = $suppBD->getRepository(Candidature::class)->find($id);

        $suppBD->remove($suppCandidature);
        // Execution
        $suppBD->flush();
        return $this->redirectToRoute('listCand');
    }
    /**
     * @Route("/list", name="listCand")
     */
    public function list()
    {
        // Appel de Doctrine
        $display = $this->getDoctrine()->getManager();

        $repository = $display->getRepository(Candidature::class);
        $listCandidature = $repository->findAll();

        return $this->render('candidature/list.html.twig', array('lesCandi'=>$listCandidature));
    }
}
