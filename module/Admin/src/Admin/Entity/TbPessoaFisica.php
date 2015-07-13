<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * TbPessoaFisica
 *
 * @ORM\Table(name="tb_pessoa_fisica")
 * @ORM\Entity(repositoryClass="Application\Repository\PessoaFisicaRepository")
 */
class TbPessoaFisica implements InputFilterAwareInterface
{

    protected $inputFilter;
    /**
     * @var string
     *
     * @ORM\Column(name="num_cpf", type="string", length=20, nullable=true)
     */
    private $numCpf;

    /**
     * @var string
     *
     * @ORM\Column(name="num_rg", type="string", length=30, nullable=true)
     */
    private $numRg;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_sexo", type="string", length=1, nullable=true)
     */
    private $codSexo;

    /**
     * @var \Admin\Entity\TbPessoa
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Admin\Entity\TbPessoa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="seq_pessoa", referencedColumnName="seq_pessoa")
     * })
     */
    private $seqPessoa;

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
        $this->numCpf = (isset($data['numCpf'])) ? $data['numCpf'] : null;
        $this->numRg = (isset($data['numRg'])) ? $data['numRg'] : null;
        $this->codSexo = (isset($data['codSexo'])) ? $data['codSexo'] : null;
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
                'name' => 'numCpf',
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
                            'min' => 11,
                            'max' => 11,
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
    public function getCodSexo()
    {
        return $this->codSexo;
    }

    /**
     * @param string $codSexo
     */
    public function setCodSexo($codSexo)
    {
        $this->codSexo = $codSexo;
    }

    /**
     * @return string
     */
    public function getNumCpf()
    {
        return $this->numCpf;
    }

    /**
     * @param string $numCpf
     */
    public function setNumCpf($numCpf)
    {
        $this->numCpf = $numCpf;
    }

    /**
     * @return string
     */
    public function getNumRg()
    {
        return $this->numRg;
    }

    /**
     * @param string $numRg
     */
    public function setNumRg($numRg)
    {
        $this->numRg = $numRg;
    }

    /**
     * @return TbPessoa
     */
    public function getSeqPessoa()
    {
        return $this->seqPessoa;
    }

    /**
     * @param TbPessoa $seqPessoa
     */
    public function setSeqPessoa($seqPessoa)
    {
        $this->seqPessoa = $seqPessoa;
    }
}

