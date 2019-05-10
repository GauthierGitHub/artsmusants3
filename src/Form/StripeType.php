<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StripeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('field_name')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
/*
            <form id="stripeButton" action="{{ path('home')}}" method="POST">
                <input type="hidden" name="_token" value="{{ customer._token }}" 

                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="pk_test_aPwxy7NiIZinXuJEOsOgJJhf" data-amount="{{ painting.price }}"
                    data-email="{{ customer.mail }}" data-label="Pay with card" data-name="Arts Musants"
                    data-description="Widget" data-image="{{ asset('images/logo.jpg') }}t" data-locale="auto"
                    data-currency="eur">
                </script>
            </form>
*/