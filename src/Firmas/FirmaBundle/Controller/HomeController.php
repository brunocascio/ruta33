<?php
//src/Firmas/FirmaBundle/Controller/HomeController.php

namespace Firmas\FirmaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;  
use Symfony\Component\HttpFoundation\Request;

use Firmas\FirmaBundle\Entity\Persona;
use Firmas\FirmaBundle\Form\PersonaType;

use Symfony\Component\HttpFoundation\Session\Session;

class HomeController extends Controller{

    
    public function indexAction(){

       // Creamos una instancia de persona
       $persona = new Persona();

       $formulario = $this->createForm(new PersonaType(), $persona);

       return $this->render('FirmasFirmaBundle:Home:index.html.twig',
        array(
       		'formulario_firma' => $formulario->createView(),
       	));
    }

    public function saveAction(Request $peticion){

        $persona = new Persona();

        $formulario = $this->createForm(new PersonaType(), $persona);

           $formulario->handleRequest($peticion);

       		if( $formulario->isValid() ){
       			$em = $this->getDoctrine()->getManager();
			      $em->persist($persona);

			      $em->flush();

            // ===================            ===========================
            // =================== SEGURIDAD  ===========================
            // ===================            ===========================
            $ip = $peticion->getClientIp();
            $dni = $persona->getDni();
            $nombre = $persona->getNombre();
            $object_fecha = $persona->getFechaFirma();
            $fecha = date('Y-m-d H:i:s');

            $conn = $this->get('database_connection');
            $sql = "INSERT INTO Seguridad VALUES('','$nombre','$dni','$fecha','$ip')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            // ===================            ===========================

    			    return $this->render('FirmasFirmaBundle:Home:index.html.twig',
                    array(
                        'Mensaje' => '<div class="alert alert-success">La Firma ha sido Guardada</div>',
                    ));
       		}

          return $this->render('FirmasFirmaBundle:Home:index.html.twig',
                array(
                    'Mensaje' => '<div class="alert alert-danger">La Firma NO ha sido Guardada. <br/>
                                 - Puede deberse a que usted YA SE ENCUENTRA en la lista. <br/>
                                 - Los Campos ingresados no mantienen el FORMATO requerido.</div>',
                ));          
    }



    public function listaAction(Request $request){

       if($request->getMethod() == 'POST'){

            $resultado = $request->request->get('dni');
            
            $firmas= false;

            if( (strlen($resultado) > 5) && (strlen($resultado) < 9) && is_numeric($resultado) ){
                $firmas = $this->getDoctrine()
                ->getRepository('FirmasFirmaBundle:Persona')
                ->findByDni($resultado);
            }

            if(!$firmas){
                 return $this->render('FirmasFirmaBundle:Lista:lista.html.twig',
                     array('Mensaje_Lista_Vacia' => 'No existe la firma.')
                 );
            }

            return $this->render('FirmasFirmaBundle:Lista:lista.html.twig',
                                 array('Mensaje_encontrado' => 'Usted ya se encuentra en la lista.',
                                       'firmas'    => $firmas,
                                       )
                        );
        }

        return $this->render('FirmasFirmaBundle:Lista:lista.html.twig');
    }



    public function listaByNameAction(Request $request){

        $session = new Session();
        $session->start();

        if($request->getMethod() == 'POST'){

            $nombre = $request->request->get('nombre');
            $session->set('nombre', $nombre); 
        }

        $nombre = $session->get('nombre');

        $firmas = $this->getDoctrine()->getManager()
                  ->createQuery('SELECT p FROM FirmasFirmaBundle:Persona p WHERE p.nombre LIKE :nombre')
                  ->setParameter('nombre', '%'.$nombre.'%');

              $paginator  = $this->get('knp_paginator');

              $pagination = $paginator->paginate(
                        $firmas,
                        $this->get('request')->query->get('page', 1)/*page number*/,
                        20/*limit per page*/
              );

           return $this->render('FirmasAdminBundle:Persona:index.html.twig',
                          array(
                                'titulo'    => 'con nombre: '.$nombre,
                                'pagination' => $pagination,
                          )
            );
    }


    public function estadisticasAction(){

        $em = $this->getDoctrine()->getManager();
        $firmas = $em->createQuery("SELECT p.ciudad FROM FirmasFirmaBundle:Persona p")->getResult();

        if(!$firmas){ 
            return $this->render('FirmasFirmaBundle:Lista:estadisticas.html.twig',
                    array(
                        'Mensaje_Lista_Vacia' => 'No existen estadísticas',
                    )
            );
        }

       $C = array();
        foreach ($firmas as $P) {
            $ciudad = array_pop($P);
            if (!array_key_exists($ciudad, $C)){
                $C[$ciudad] = 1;
            }else{
                $C[$ciudad]++;
            }
        }

        arsort($C);
        

        return $this->render('FirmasFirmaBundle:Lista:estadisticas.html.twig',
                array(
                    'Ciudades' => $C,
                    'total_de_votos' => array_sum($C),
                    )
        ); 
    }

}