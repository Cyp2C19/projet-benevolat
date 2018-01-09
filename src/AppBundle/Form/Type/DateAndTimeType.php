<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 26/11/2017
 * Time: 22:59
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\FormBuilderInterface;


class DateAndTimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new DateTimeToStringTransformer(
            null, null, 'd-m-Y'
        ));
    }
    public function getParent()
    {
        return TextType::class;
    }
}