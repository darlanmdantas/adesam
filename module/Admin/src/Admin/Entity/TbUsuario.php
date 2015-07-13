<?php

namespace Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * TbUsuario
 *
 * @ORM\Table(name="tb_usuario", indexes={@ORM\Index(name="IDX_5DB26AFFF07A9077", columns={"seq_pessoa"}), @ORM\Index(name="IDX_5DB26AFF787F5033", columns={"seq_tipo_usuario"})})
 * @ORM\Entity(repositoryClass="Admin\Repository\UsuarioRepository")
 */
class TbUsuario implements InputFilterAwareInterface
{

    protected $inputFilter;
    /**
     * @var integer
     *
     * @ORM\Column(name="seq_usuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="tb_usuario_seq_usuario_seq", allocationSize=1, initialValue=1)
     */
    private $seqUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_usuario", type="string", length=200, nullable=true)
     */
    private $nomUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="des_senha", type="string", length=200, nullable=true)
     */
    private $desSenha;

    /**
     * @var string
     *
     * @ORM\Column(name="sit_usuario", type="string", length=1, nullable=true)
     */
    private $sitUsuario;

    /**
     * @var \Admin\Entity\TbPessoa
     *
     * @ORM\ManyToOne(targetEntity="Admin\Entity\TbPessoa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="seq_pessoa", referencedColumnName="seq_pessoa")
     * })
     */
    private $seqPessoa;

    /**
     * @var \Admin\Entity\TbTipoUsuario
     *
     * @ORM\ManyToOne(targetEntity="Admin\Entity\TbTipoUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="seq_tipo_usuario", referencedColumnName="seq_tipo_usuario")
     * })
     */
    private $seqTipoUsuario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dat_cadastro", type="datetime", nullable=true)
     */
    private $datCadastro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dat_alteracao", type="datetime", nullable=true)
     */
    private $datAlteracao;

    /**
     * @var \Admin\Entity\TbUsuario
     * @ORM\Column(name="seq_usuario_cadastrou", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Admin\Entity\TbUsuario", inversedBy="seqUsuarioUsuario")
     * @ORM\JoinColumn(nullable=false, name="seq_usuario_cadastrou", referencedColumnName="seq_usuario", onDelete="RESTRICT")
     */
    protected $seqUsuarioCadastrou;

    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\TbUsuario", mappedBy="seqUsuarioCadastrou")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $seqUsuarioUsuario;

    public function __construct()
    {
        $this->seqUsuarioUsuario = new ArrayCollection();
    }

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
        $this->seqUsuario = (isset($data['seqUsuario'])) ? $data['seqUsuario'] : null;
        $this->nomUsuario = (isset($data['nomUsuario'])) ? $data['nomUsuario'] : null;
        $this->seqUsuarioCadastrou = (isset($data['seqUsuarioCadastrou'])) ? $data['seqUsuarioCadastrou'] : 1;
        $this->desSenha = (isset($data['desSenha'])) ? $data['desSenha'] : null;
        $this->datCadastro = (isset($data['datCadastro'])) ? $data['datCadastro'] : new \DateTime('now');
        $this->datAlteracao = (isset($data['datAlteracao'])) ? $data['datAlteracao'] : new \DateTime('now');
        $this->sitUsuario = (isset($data['sitUsuario'])) ? $data['sitUsuario'] : 'I';
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

            $inputFilter->add($factory->createInput(array(
                'name' => 'nomUsuario',
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

            $inputFilter->add($factory->createInput(array(
                'name' => 'desSenha',
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
                            'min' => 5,
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
     * @return \DateTime
     */
    public function getDatAlteracao()
    {
        return $this->datAlteracao;
    }

    /**
     * @param \DateTime $datAlteracao
     */
    public function setDatAlteracao($datAlteracao)
    {
        $this->datAlteracao = $datAlteracao;
    }

    /**
     * @return \DateTime
     */
    public function getDatCadastro()
    {
        return $this->datCadastro;
    }

    /**
     * @param \DateTime $datCadastro
     */
    public function setDatCadastro($datCadastro)
    {
        $this->datCadastro = $datCadastro;
    }

    /**
     * @return string
     */
    public function getDesSenha()
    {
        return $this->desSenha;
    }

    /**
     * @param string $desSenha
     */
    public function setDesSenha($desSenha)
    {
        $this->desSenha = $desSenha;
    }

    /**
     * @return string
     */
    public function getNomUsuario()
    {
        return $this->nomUsuario;
    }

    /**
     * @param string $nomUsuario
     */
    public function setNomUsuario($nomUsuario)
    {
        $this->nomUsuario = $nomUsuario;
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

    /**
     * @return TbTipoUsuario
     */
    public function getSeqTipoUsuario()
    {
        return $this->seqTipoUsuario;
    }

    /**
     * @param TbTipoUsuario $seqTipoUsuario
     */
    public function setSeqTipoUsuario($seqTipoUsuario)
    {
        $this->seqTipoUsuario = $seqTipoUsuario;
    }

    /**
     * @return int
     */
    public function getSeqUsuario()
    {
        return $this->seqUsuario;
    }

    /**
     * @param int $seqUsuario
     */
    public function setSeqUsuario($seqUsuario)
    {
        $this->seqUsuario = $seqUsuario;
    }

    /**
     * @return string
     */
    public function getSitUsuario()
    {
        return $this->sitUsuario;
    }

    /**
     * @param string $sitUsuario
     */
    public function setSitUsuario($sitUsuario)
    {
        $this->sitUsuario = $sitUsuario;
    }
}

