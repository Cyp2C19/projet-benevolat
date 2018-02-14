<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 19/12/2017
 * Time: 09:15
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Benevole
 *
 * @ORM\Table(name="benevole")
 * @ORM\Entity
 * @UniqueEntity(fields = "email", targetClass = "AppBundle\Entity\Utilisateur", message="fos_user.email.already_used")
 */
class Benevole extends Utilisateur
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\Length(
     *     min=8,
     *     max=256,
     *     minMessage="Le mot de passe doit être de 8 caractères minimum.",
     *     groups={"Profile", "ResetPassword", "Registration", "ChangePassword"}
     * )
     */
    protected $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=15, nullable=false)
     */
    private $telephone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date", nullable=false)
     */
    private $dateNaissance;

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    public function getAge(){
        $today = new \DateTime();
        return $this->dateNaissance->diff($today)->y;
    }

    /**
     * @param \DateTime $dateNaissance
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
    }

    public function __construct() {
        $this->setRoles(array('ROLE_BENEVOLE'));
    }
}