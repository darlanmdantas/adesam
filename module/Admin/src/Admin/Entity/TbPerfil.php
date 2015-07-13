<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * TbPerfil
 *
 * @ORM\Table(name="tb_perfil")
 * @ORM\Entity(repositoryClass="Admin\Repository\PerfilRepository")
 */
class TbPerfil implements InputFilterAwareInterface
{

    protected $inputFilter;
    /**
     * @var integer
     *
     * @ORM\Column(name="seq_perfil", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="tb_perfil_seq_perfil_seq", allocationSize=1, initialValue=1)
     */
    private $seqPerfil;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_perfil", type="string", length=50, nullable=true)
     */
    private $nomPerfil;

    /**
     * @var string
     *
     * @ORM\Column(name="des_perfil", type="string", length=255, nullable=true)
     */
    private $desPerfil;

    /**
     * @var string
     *
     * @ORM\Column(name="sit_perfil", type="string", length=1, nullable=true)
     */
    private $sitPerfil;

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * Populate from an array.
     *
     * @param $data
     */
    public function exchangeArray($data)
    {
        $this->seqPerfil = (isset($data['seqPerfil'])) ? $data['seqPerfil'] : 0;
        $this->nomPerfil = (isset($data['nomPerfil'])) ? $data['nomPerfil'] : null;
        $this->desPerfil = (isset($data['desPerfil'])) ? $data['desPerfil'] : null;
        $this->sitPerfil = (isset($data['sitPerfil'])) ? $data['sitPerfil'] : 'A';
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Não encontrado");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $factory = new InputFactory();

            /*foi necessario adicionar por causa da configuracaod o form*/
            $inputFilter->add($factory->createInput(array(
                'name' => 'seqPerfil',
                'required' => false
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'nomPerfil',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 80,
                        ),
                    ),
                ),
            )));
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * @return string
     */
    public function getDesPerfil()
    {
        return $this->desPerfil;
    }

    /**
     * @param string $desPerfil
     */
    public function setDesPerfil($desPerfil)
    {
        $this->desPerfil = $desPerfil;
    }

    /**
     * @return string
     */
    public function getNomPerfil()
    {
        return $this->nomPerfil;
    }

    /**
     * @param string $nomPerfil
     */
    public function setNomPerfil($nomPerfil)
    {
        $this->nomPerfil = $nomPerfil;
    }

    /**
     * @return int
     */
    public function getSeqPerfil()
    {
        return $this->seqPerfil;
    }

    /**
     * @param int $seqPerfil
     */
    public function setSeqPerfil($seqPerfil)
    {
        $this->seqPerfil = $seqPerfil;
    }

    /**
     * @return string
     */
    public function getSitPerfil()
    {
        return $this->sitPerfil;
    }

    /**
     * @param string $sitPerfil
     */
    public function setSitPerfil($sitPerfil)
    {
        $this->sitPerfil = $sitPerfil;
    }

}

