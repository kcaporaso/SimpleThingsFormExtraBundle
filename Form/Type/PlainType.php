<?php

namespace SimpleThings\FormExtraBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * A Form type that just renders the field as a p tag. This is useful for forms where certain field
 * need to be shown but not editable.
 *
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 * @author Gordon Franke <info@nevalon.de>
 */
class PlainType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'read_only' => true,
            'compound' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'formextra_plain';
    }
}
