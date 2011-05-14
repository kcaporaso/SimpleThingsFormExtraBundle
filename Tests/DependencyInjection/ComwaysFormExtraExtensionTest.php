<?php

namespace Comways\FormExtraBundle\Tests\DependencyInjection;

use Comways\FormExtraBundle\DependencyInjection\ComwaysFormExtraExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ComwaysFormExtraExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $container = new ContainerBuilder();
        $extension = new ComwaysFormExtraExtension();
        $extension->load(array(), $container);

        $parameters = array(
            'form.type.recaptcha.class' => 'Comways\FormExtraBundle\Form\Type\RecaptchaType',
            'form.extension.field.class' => 'Comways\FormExtraBundle\Form\Extension\FieldTypeExtension',
        );

        foreach ($parameters as $parameter => $value) {
            $this->assertEquals($container->getParameter('comways_form_extra.' . $parameter), $value);
        }

        $definitions = array(
            'form.type.recaptcha',
            'form.extension.field',
        );

        foreach ($definitions as $definition) {
            $this->assertTrue($container->hasDefinition('comways_form_extra.' . $definition));
        }
    }
}