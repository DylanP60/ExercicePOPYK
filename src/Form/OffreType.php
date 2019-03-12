<?php
namespace App\Form;

use App\Entity\Offre;
use App\Entity\Job;
use App\Entity\Contrat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, array('label' => 'Titre de l offre'))
            ->add('description', TextareaType::class, array('label' => 'Description de l offre'))
            ->add('id_job_id', EntityType::class, array('class' => Job::class, 'choice_label' => 'name', 'label'=>'Job'))
            ->add('id_contrat_id', EntityType::class, array('class' => Contrat::class, 'choice_label' => 'name', 'label'=>'Contrat'))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offre::class]);
    }
}
?>
