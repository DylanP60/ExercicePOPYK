<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contrat;
use App\Form\ContratType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @Route("/contrat", name="contrat")
 */
class ContratController extends AbstractController
{
    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request)
    {
        $contrat = new Contrat();
        $form = $this->createForm(ContratType::class, $contrat);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $contrat=$form->getData();
            VarDumper::dump($contrat);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contrat);

            $entityManager->flush();
            return $this->redirect($this->generateUrl('listCont'));

        }
        return $this->render('contrat/new.html.twig', array('form' => $form->createView(),));
    }
    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit($id, Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Contrat::class);
        $editContrat = $repository->find($id);
        // Equivalent du SELECT * where id=(paramètre) //
        $form = $this->createForm(ContactType::class, $editContrat);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() && $request->isMethod('POST'))
        {
            $editContrat = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirect($this->generateUrl('listCont'));
        }
        return $this->render('contrat/edit.html.twig', ['editContrat' => $editContrat, 'form' => $form->createView()]);
    }
    /**
     * @Route("/delete/{id}", name="delete", requirements={"id"="\d+"})
     */
    public function delete($id)
    {
        $suppBD = $this->getDoctrine()->getManager();

        $suppContrat = $suppBD->getRepository(Contrat::class)->find($id);

        $suppBD->remove($suppContrat);
        // Execution
        $suppBD->flush();
        return $this->redirectToRoute('listCont');
    }
    /**
     * @Route("/list", name="listCont")
     */
    public function list()
    {
        // Appel de Doctrine
        $display = $this->getDoctrine()->getManager();

        $repository = $display->getRepository(Contrat::class);
        $listContrat = $repository->findAll();

        return $this->render('contrat/list.html.twig', array('lesCont'=>$listContrat));
    }
}
