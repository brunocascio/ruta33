<?php

namespace Firmas\FirmaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class PersonaType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        

        $builder
            ->add('nombre','text',
                array(
                   'constraints' => array(
                                       new NotBlank(),
                                       new Length(array('min' => 2, 'max'=> 50)),
                                    )
                 ))
            ->add('dni','integer',
                 array(
                   'constraints' => array(
                                       new NotBlank(),
                                       new Type(array('type' => 'integer')),
                                       new Length(array('min' => 6, 'max' => 8)),
                                    )
                 ))
            ->add('ciudad','choice', array(
                                'choices' => array(
                                            //'17 de Agosto'     => '17 de Agosto',
                                            '30 de Agosto'     => '30 de Agosto',
                                            'Arroyo Corto'     => 'Arroyo Corto',
                                            //'América'          => 'América',
                                            //'Arroyo Venado'    => 'Arroyo Venado',
                                            //'Azul'             => 'Azul',
                                            'Bahía Blanca'     => 'Bahía Blanca',
                                            //'Berazategui'      => 'Berazategui',
                                            //'Bernal'           => 'Bernal',
                                            //'Bolívar'          => 'Bolívar',
                                            //'Bonifacio'        => 'Bonifacio',
                                            //'Bordenave'        => 'Bordenave',
                                            //'Brandsen'         => 'Brandsen',
                                            'Buenos Aires'     => 'Buenos Aires',
                                            //'Cabildo'          => 'Cabildo',
                                            'Capital Federal'  => 'Capital Federal',
                                            'Casbas'           => 'Casbas',
                                            'Coronel Dorrego'  => 'Coronel Dorrego',
                                            'Coronel Suárez'   => 'Coronel Suárez',
                                            //'Coronel Pringles' => 'Coronel Pringles',
                                            'Carhué'           => 'Carhué',
                                            //'Chasicó'          => 'Chasicó',
                                            //'Cipolletti'       => 'Cipolletti',
                                            //'Colonia San Martín' => 'Colonia San Martín',
                                            'Daireaux'         => 'Daireaux',
                                            'Darregueira'      => 'Darregueira',
                                            'Dufaur'           => 'Dufaur',
                                            //'El Calafate'      => 'El Calafate',
                                            'Espartillar'      => 'Espartillar',
                                            //'General Pico'     => 'General Pico',
                                            'Goyena'           => 'Goyena',
                                            'Guaminí'          => 'Guaminí',
                                            //'Henderson'        => 'Henderson',
                                            'Huanguelén'       => 'Huanguelén',
                                            'Ingeniero White'  => 'Ingeniero White',
                                            //'Jose Clemente Paz'  => 'Jose Clemente Paz',
                                            //'Laguna Alsina'    => 'Laguna Alsina',
                                            'La Plata'         => 'La Plata',
                                            //'Lanús'            => 'Lanús',
                                            //'Laprida'          => 'Laprida',
                                            //'Lincoln'          => 'Lincoln',
                                            //'Oriente'          => 'Oriente',
                                            'Médanos'          => 'Médanos',
                                            //'Monte Hermoso'    => 'Monte Hermoso',
                                            //'Neuquén'          => 'Neuquén',
                                            'Olavarría'        => 'Olavarría',
                                            //'Pedro Luro'       => 'Pedro Luro',
                                            'Pigüé'            => 'Pigüé',
                                            'Puan'             => 'Puan',
                                            //'Puerto Deseado'   => 'Puerto Deseado',
                                            //'Puerto Madryn'    => 'Puerto Madryn',
                                            'Punta Alta'       => 'Punta Alta',
                                           //'Quilmes'          => 'Quilmes',
                                            //'Río Gallegos'     => 'Río Gallegos',
                                            'Rivera'           => 'Rivera',
                                            'Saavedra'         => 'Saavedra',
                                            //'Salazar'          => 'Salazar',
                                            'Saldungaray'      => 'Saldungaray',
                                            'Salliqueló'       => 'Salliqueló',
                                            //'San Antonio Oeste' => 'San Antonio Oeste',
                                            //'San Justo'        => 'San Justo',
                                            //'Santa Fe'         => 'Santa Fe',
                                            //'San Miguel Arcangel' => 'San Miguel Arcangel',
                                            'Sierra de la Ventana' => 'Sierra de la Ventana',
                                            //'Sierra de los Padres' => 'Sierra de los Padres',
                                            //'Tandil'           => 'Tandil',
                                            //'Tigre'            => 'Tigre',
                                            'Tornquist'        => 'Tornquist',
                                            'Trenque Lauquen' => 'Trenque Lauquen',
                                            //'Tres Arroyos'     => 'Tres Arroyos',
                                            'Tres Lomas'       => 'Tres Lomas',
                                            //'Tres Picos'       => 'Tres Picos',
                                            //'Trelew'           => 'Trelew',
                                            //'Ushuaia'          => 'Ushuaia',
                                            //'Villa Gesel'      => 'Villa Gesel',
                                            'Villa Iris'       => 'Villa Iris',
                                            //'Villa la Angostura' => 'Villa la Angostura',
                                            //'Villa la Arcadia' => 'Villa la Arcadia',
                                            //'Villa María'      => 'Villa María',
                                            //'Villa Maza'       => 'Villa Maza',
                                            'Villa Ventana'    => 'Villa Ventana',
                                            'Otras'            => 'Otras',
                                    ),
                            )    
                )           
            ->add('enviar', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Firmas\FirmaBundle\Entity\Persona',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'firma_item',
        ));
    }

    public function getName()
    {
        return 'firmas_firmabundle_personatype';
    }

}
