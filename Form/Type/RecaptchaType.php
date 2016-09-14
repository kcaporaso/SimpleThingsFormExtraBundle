<?php

namespace SimpleThings\FormExtraBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\InvalidConfigurationException;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

use SimpleThings\FormExtraBundle\Service\Recaptcha;
use SimpleThings\FormExtraBundle\Form\DataTransformer\RecaptchaTransformer;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * A ReCaptcha type for use with Google ReCatpcha services. It embeds two fields that are used
 * for manual validation and show of the widget.
 *
 * The DataTransformer takes the entered request information and validates them agains the 
 * Google Recaptcha API.
 *
 * example:
 *     $builder->add('recaptcha', 'recaptcha', array(
 *         'private_key' => 'private_key_here_required',
 *         'public_key' => 'public_key_here_required',
 *     ))
 *
 *
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 * @author Jeffrey Boehm <post@jeffrey-boehm.de>
 */
class RecaptchaType extends AbstractType
{
    /**
     * @var Recaptcha
     */
    protected $recaptcha;

    /**
     * @var string
     */
    protected $publicKey;

    /**
     * @param Recaptcha $recaptcha
     * @param string    $publicKey
     */
    public function __construct(Recaptcha $recaptcha, $publicKey)
    {
        $this->recaptcha = $recaptcha;
        $this->publicKey = $publicKey;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ((string) $this->publicKey === '') {
            throw new InvalidConfigurationException('A public key must be set and not empty.');
        }

        $builder
            ->add('recaptcha_challenge_field', 'text')
            ->add('recaptcha_response_field', 'hidden', array(
                'data' => 'manual_challenge',
            ));

        $builder->addViewTransformer(new RecaptchaTransformer($this->recaptcha));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['public_key'] = $this->publicKey;
        $view->vars['widget_options'] = $options['widget_options'];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'required'        => true,
            'mapped'          => false,
            'widget_options'  => array(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'formextra_recaptcha';
    }
}
