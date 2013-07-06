<?php
//src/Firmas/AdminBundle/Controller/AdminController.php
namespace Firmas\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Firmas\FirmaBundle\Entity\Persona;
use Firmas\FirmaBundle\Form\PersonaType;

class AdminController extends Controller
{
    public function indexAction()
    {
    	$nombre = $this->get('security.context')->getToken()->getUser()->getUsername(); 

        return $this->render('FirmasAdminBundle:Home:index.html.twig',
        					array(
        						'user_name' => $nombre,
        						)
        		);
    }


    public function listadorevisarAction(){
    		$em = $this->getDoctrine()->getManager();
            
            $listado = $em->createQuery('SELECT p FROM FirmasFirmaBundle:Persona p WHERE p.ciudad = :c')
            ->setParameter('c','Otras');

            if (!$listado){
            	return $this->render('FirmasAdminBundle:Persona:index.html.twig',
        					array(
        						'Mensaje' => 'No hay Firmas por el momento',
        						)
        		); 
            }

           $paginator  = $this->get('knp_paginator');

           $pagination = $paginator->paginate(
                        $listado,
                        $this->get('request')->query->get('page', 1)/*page number*/,
                        20/*limit per page*/
                    );

           return $this->render('FirmasAdminBundle:Persona:index.html.twig',array(
					'pagination' => $pagination,
                    'titulo'     => '"Otras"',
                   // 'total'  => count($listado),
        			)
        	);  
    }

    public function listadoSinCompletarAction(){
            
            $em = $this->getDoctrine()->getManager();
            
            $listado = $em->createQuery('SELECT p FROM FirmasFirmaBundle:Persona p WHERE p.ciudad = :c')
            ->setParameter('c', '')->getResult();

             if (!$listado){
                return $this->render('FirmasAdminBundle:Persona:index.html.twig',
                            array(
                                'Mensaje' => 'No hay Firmas por el momento',
                                )
                ); 
            }

           $paginator  = $this->get('knp_paginator');

           $pagination = $paginator->paginate(
                        $listado,
                        $this->get('request')->query->get('page', 1)/*page number*/,
                        20/*limit per page*/
                    );

           return $this->render('FirmasAdminBundle:Persona:index.html.twig',array(
                    'pagination' => $pagination,
                    'titulo'     => '"Sin Completar"',
                   // 'total'  => count($listado),
                    )
            );  
    }


}