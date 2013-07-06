<?php

namespace Firmas\FirmaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Persona
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("dni")
 */
class Persona
{
    
    /**
     * @var integer
     *
     * @ORM\Column(name="persona_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    
    /**
    * @var string
    *
    * @ORM\Column(name="persona_nombre", type="string", length=50 )
    * @Assert\Type("string")
    * @Assert\NotNull()
    * @Assert\NotBlank()
    * @Assert\Length(
     *      min = "2",
     *      max = "50",
     *      minMessage = "El nombre no puede tener menos de {{ limit }} caracteres",
     *      maxMessage = "El nombre no puede tener más de {{ limit }} caracteres"
     * )
    */
    private $nombre;


    /**
     * @var integer
     *
     * @ORM\Column(name="persona_dni", unique=true, type="integer", length=8)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("integer")
     * @Assert\Length(
     *      min = "6",
     *      max = "8",
     *      minMessage = "El dni no puede tener menos de {{ limit }} dígitos",
     *      maxMessage = "El dni no puede tener más de {{ limit }} dígitos"
     * )
     */
    private $dni;

    
    /**
    * @var string
    *
    * @ORM\Column(name="persona_ciudad", type="string", length=50)
    * @Assert\NotBlank()
    * @Assert\NotNull()
    * @Assert\Type("string")
    * @Assert\Length(
     *      min = "4",
     *      max = "50",
     *      minMessage = "La ciudad no puede tener menos de {{ limit }} caracteres",
     *      maxMessage = "La ciudad no puede tener más de {{ limit }} caracteres"
     * )
    */
    private $ciudad;

     /**
    * @var datetime
    *
    * @ORM\Column(name="persona_fecha", type="datetime")
    * @Assert\Type("\DateTime")
    */
    private $fecha_firma;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Persona
     */
    public function setNombre($nombre)
    {
        $this->nombre = str_replace(array(".",",","-",":","0","1","2","3","4","5","6","7","8","9"),"",trim(ucwords(strtolower($nombre))));
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set dni
     *
     * @param integer $dni
     * @return Persona
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    
        return $this;
    }

    /**
     * Get dni
     *
     * @return integer 
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set ciudad
     *
     * @param string $ciudad
     * @return Persona
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
    
        return $this;
    }

    /**
     * Get ciudad
     *
     * @return string 
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * @ORM\PrePersist
     */
    public function setPreFechaFirma()
    {
        $this->fecha_firma = new \DateTime("now");
    }

    /**
     * Set fecha_firma
     *
     * @param \DateTime $fechaFirma
     * @return Persona
     */
    public function setFechaFirma($fechaFirma)
    {
        $fecha_firma = new \DateTime();
        
        $this->fecha_firma = $fechaFirma;
    
        return $this;
    }

    /**
     * Get fecha_firma
     *
     * @return \DateTime 
     */
    public function getFechaFirma()
    {
        return $this->fecha_firma;
    }
}