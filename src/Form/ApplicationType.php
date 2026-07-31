<?php

namespace App\Form;

use App\Entity\Application;
use App\Entity\Link;
use App\Entity\User;
use App\Repository\LinkRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var User $user */
        $user = $options['user'];

        $builder
            ->add('motivation')
            ->add('cv_url')
            ->add('links', EntityType::class, [
                'class' => Link::class,
                'choice_label' => 'label',
                'label' => 'Liens à joindre',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'query_builder' => function (LinkRepository $repository) use ($user) {
                    return $repository->createQueryBuilder('e')
                        ->andWhere('e.user = :user')
                        ->setParameter('user', $user);
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
        $resolver->setRequired('user');
        $resolver->setAllowedTypes('user', User::class);
    }
}
