<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Job;
use App\Form\JobType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @Route("/job", name="job")
 */
class JobController extends AbstractController
{
    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request)
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $job=$form->getData();
            VarDumper::dump($job);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($job);

            $entityManager->flush();
            return $this->redirect($this->generateUrl('listJob'));

        }
        return $this->render('job/new.html.twig', array('form' => $form->createView(),));
    }
    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit($id, Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Job::class);
        $editJob = $repository->find($id);
        // Equivalent du SELECT * where id=(paramètre) //
        $form = $this->createForm(JobType::class, $editJob);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() && $request->isMethod('POST'))
        {
            $editJob = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirect($this->generateUrl('listJob'));
        }
        return $this->render('job/edit.html.twig', ['editJob' => $editJob, 'form' => $form->createView()]);
    }
    /**
     * @Route("/delete/{id}", name="delete", requirements={"id"="\d+"})
     */
    public function delete($id)
    {
        $suppBD = $this->getDoctrine()->getManager();

        $suppJob = $suppBD->getRepository(Job::class)->find($id);

        $suppBD->remove($suppJob);
        // Execution
        $suppBD->flush();
        return $this->redirectToRoute('listJob');
    }
    /**
     * @Route("/list", name="listJob")
     */
    public function list()
    {
        // Appel de Doctrine
        $display = $this->getDoctrine()->getManager();

        $repository = $display->getRepository(Job::class);
        $listJob = $repository->findAll();

        return $this->render('job/list.html.twig', array('lesJob'=>$listJob));
    }
}
