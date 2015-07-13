<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * TbPessoa
 *
 * @ORM\Table(name="tb_pessoa")
 * @ORM\Entity(repositoryClass="Application\Repository\PessoaRepository")
 */
class TbPessoa implements InputFilterAwareInterface
{

    protected $inputFilter;
    /**
     * @var integer
     *
     * @ORM\Column(name="seq_pessoa", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="tb_pessoa_seq_pessoa_seq", allocationSize=1, initialValue=1)
     */
    private $seqPessoa;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_pessoa", type="string", length=200, nullable=true)
     */
    private $nomPessoa;

    /**
     * @var string
     *
     * @ORM\Column(name="tip_pessoa", type="string", length=1, nullable=true)
     */
    private $tipPessoa;

    /**
     * @var string
     *
     * @ORM\Column(name="sit_pessoa", type="string", length=1, nullable=true)
     */
    private $sitPessoa;

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
     * @param array $data
     */

    public function exchangeArray($data)
    {
        $this->seqPessoa = (isset($data['seqPessoa'])) ? $data['seqPessoa'] : null;
        $this->nomPessoa = (isset($data['nomPessoa'])) ? $data['nomPessoa'] : null;
        $this->tipPessoa = (isset($data['tipPessoa'])) ? $data['tipPessoa'] : 'F';
        $this->sitPessoa = (isset($data['sitPessoa'])) ? $data['sitPessoa'] : 'I';
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
                'name' => 'seqPessoa',
                'required' => false
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'nomPessoa',
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
    public function getNomPessoa()
    {
        return $this->nomPessoa;
    }

    /**
     * @param string $nomPessoa
     */
    public function setNomPessoa($nomPessoa)
    {
        $this->nomPessoa = $nomPessoa;
    }

    /**
     * @return int
     */
    public function getSeqPessoa()
    {
        return $this->seqPessoa;
    }

    /**
     * @param int $seqPessoa
     */
    public function setSeqPessoa($seqPessoa)
    {
        $this->seqPessoa = $seqPessoa;
    }

    /**
     * @return string
     */
    public function getSitPessoa()
    {
        return $this->sitPessoa;
    }

    /**
     * @param string $sitPessoa
     */
    public function setSitPessoa($sitPessoa)
    {
        $this->sitPessoa = $sitPessoa;
    }

    /**
     * @return string
     */
    public function getTipPessoa()
    {
        return $this->tipPessoa;
    }

    /**
     * @param string $tipPessoa
     */
    public function setTipPessoa($tipPessoa)
    {
        $this->tipPessoa = $tipPessoa;
    }

}

