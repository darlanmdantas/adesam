<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * TbRecurso
 *
 * @ORM\Table(name="tb_recurso")
 * @ORM\Entity(repositoryClass="Admin\Repository\RecursoRepository")
 */
class TbRecurso implements InputFilterAwareInterface
{

    protected $inputFilter;
    /**
     * @var integer
     *
     * @ORM\Column(name="seq_recurso", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="tb_recurso_seq_recurso_seq", allocationSize=1, initialValue=1)
     */
    private $seqRecurso;

    /**
     * @var string
     *
     * @ORM\Column(name="des_recurso", type="string", length=200, nullable=true)
     */
    private $desRecurso;

    /**
     * @var string
     *
     * @ORM\Column(name="sit_recurso", type="string", length=1, nullable=true)
     */
    private $sitRecurso;

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
        $this->seqRecurso = (isset($data['seqRecurso'])) ? $data['seqRecurso'] : 0;
        $this->desRecurso = (isset($data['desRecurso'])) ? $data['desRecurso'] : null;
        $this->sitRecurso = (isset($data['sitRecurso'])) ? $data['sitRecurso'] : 'A';
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
                'name' => 'seqRecurso',
                'required' => false
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'desRecurso',
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
                            'max' => 200,
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
    public function getDesRecurso()
    {
        return $this->desRecurso;
    }

    /**
     * @param string $desRecurso
     */
    public function setDesRecurso($desRecurso)
    {
        $this->desRecurso = $desRecurso;
    }

    /**
     * @return int
     */
    public function getSeqRecurso()
    {
        return $this->seqRecurso;
    }

    /**
     * @param int $seqRecurso
     */
    public function setSeqRecurso($seqRecurso)
    {
        $this->seqRecurso = $seqRecurso;
    }

    /**
     * @return string
     */
    public function getSitRecurso()
    {
        return $this->sitRecurso;
    }

    /**
     * @param string $sitRecurso
     */
    public function setSitRecurso($sitRecurso)
    {
        $this->sitRecurso = $sitRecurso;
    }

}

