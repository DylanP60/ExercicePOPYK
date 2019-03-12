<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Competence;
use App\Form\CompetenceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @Route("/competence", name="competence")
 */
class CompetenceController extends AbstractController
{
    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request)
    {
        $competence = new Competence();
        $form = $this->createForm(CompetenceType::class, $competence);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $competence=$form->getData();
            VarDumper::dump($competence);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($competence);

            $entityManager->flush();
            return $this->redirect($this->generateUrl('listComp'));

        }
        return $this->render('competence/new.html.twig', array('form' => $form->createView(),));
    }
    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit($id, Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Competence::class);
        $editCompetence = $repository->find($id);
        // Equivalent du SELECT * where id=(paramètre) //
        $form = $this->createForm(Competence::class, $editCompetence);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() && $request->isMethod('POST'))
        {
            $editCompetence = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirect($this->generateUrl('listComp'));
        }
        return $this->render('competence/edit.html.twig', ['editCandidature' => $editCompetence, 'form' => $form->createView()]);
    }
    /**
     * @Route("/delete/{id}", name="delete", requirements={"id"="\d+"})
     */
    public function delete($id)
    {
        $suppBD = $this->getDoctrine()->getManager();

        $suppCompetence = $suppBD->getRepository(Competence::class)->find($id);

        $suppBD->remove($suppCompetence);
        // Execution
        $suppBD->flush();
        return $this->redirectToRoute('listComp');
    }
    /**
     * @Route("/list", name="listComp")
     */
    public function list()
    {
        // Appel de Doctrine
        $display = $this->getDoctrine()->getManager();

        $repository = $display->getRepository(Competence::class);
        $listCompetence = $repository->findAll();

        return $this->render('competence/list.html.twig', array('lesComp'=>$listCompetence));
    }
}
