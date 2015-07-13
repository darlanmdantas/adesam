<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * TbTipoUsuario
 *
 * @ORM\Table(name="tb_tipo_usuario")
 * @ORM\Entity(repositoryClass="Admin\Repository\TipoUsuarioRepository")
 */
class TbTipoUsuario implements InputFilterAwareInterface
{

    protected $inputFilter;
    /**
     * @var integer
     *
     * @ORM\Column(name="seq_tipo_usuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="tb_tipo_usuario_seq_tipo_usuario_seq", allocationSize=1, initialValue=1)
     */
    private $seqTipoUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="des_tipo_usuario", type="string", length=30, nullable=true)
     */
    private $desTipoUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="sit_tipo_usuario", type="string", length=1, nullable=true)
     */
    private $sitTipoUsuario;

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
        $this->seqTipoUsuario = (isset($data['seqTipoUsuario'])) ? $data['seqTipoUsuario'] : 0;
        $this->desTipoUsuario = (isset($data['desTipoUsuario'])) ? $data['desTipoUsuario'] : null;
        $this->sitTipoUsuario = (isset($data['sitTipoUsuario'])) ? $data['sitTipoUsuario'] : 'A';
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
                'name' => 'seqTipoUsuario',
                'required' => false
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'desTipoUsuario',
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
    public function getDesTipoUsuario()
    {
        return $this->desTipoUsuario;
    }

    /**
     * @param string $desTipoUsuario
     */
    public function setDesTipoUsuario($desTipoUsuario)
    {
        $this->desTipoUsuario = $desTipoUsuario;
    }

    /**
     * @return int
     */
    public function getSeqTipoUsuario()
    {
        return $this->seqTipoUsuario;
    }

    /**
     * @param int $seqTipoUsuario
     */
    public function setSeqTipoUsuario($seqTipoUsuario)
    {
        $this->seqTipoUsuario = $seqTipoUsuario;
    }

    /**
     * @return string
     */
    public function getSitTipoUsuario()
    {
        return $this->sitTipoUsuario;
    }

    /**
     * @param string $sitTipoUsuario
     */
    public function setSitTipoUsuario($sitTipoUsuario)
    {
        $this->sitTipoUsuario = $sitTipoUsuario;
    }

}

