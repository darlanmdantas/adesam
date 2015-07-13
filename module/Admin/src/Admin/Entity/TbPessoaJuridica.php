<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * TbPessoaJuridica
 *
 * @ORM\Table(name="tb_pessoa_juridica")
 * @ORM\Entity(repositoryClass="Application\Repository\PessoaJuridicaRepository")
 */
class TbPessoaJuridica implements InputFilterAwareInterface
{

    protected $inputFilter;
    /**
     * @var string
     *
     * @ORM\Column(name="num_cnpj", type="string", length=20, nullable=true)
     */
    private $numCnpj;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_fantasia", type="string", length=200, nullable=true)
     */
    private $nomFantasia;

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
        $this->numCnpj = (isset($data['numCnpj'])) ? $data['numCnpj'] : null;
        $this->nomFantasia = (isset($data['nomFantasia'])) ? $data['nomFantasia'] : null;
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
                'name' => 'numCnpj',
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
                            'min' => 14,
                            'max' => 14,
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
    public function getNomFantasia()
    {
        return $this->nomFantasia;
    }

    /**
     * @param string $nomFantasia
     */
    public function setNomFantasia($nomFantasia)
    {
        $this->nomFantasia = $nomFantasia;
    }

    /**
     * @return string
     */
    public function getNumCnpj()
    {
        return $this->numCnpj;
    }

    /**
     * @param string $numCnpj
     */
    public function setNumCnpj($numCnpj)
    {
        $this->numCnpj = $numCnpj;
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

