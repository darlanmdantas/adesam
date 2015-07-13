<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrUsuarioPerfilRecurso
 *
 * @ORM\Table(name="tr_usuario_perfil_recurso", indexes={@ORM\Index(name="IDX_E85C0CBE7AC04DB2", columns={"seq_perfil"}), @ORM\Index(name="IDX_E85C0CBE7F8094CC", columns={"seq_recurso"}), @ORM\Index(name="IDX_E85C0CBEEF5E13F5", columns={"seq_usuario"})})
 * @ORM\Entity(repositoryClass="Admin\Repository\UsuarioPerfilRecursoRepository")
 */
class TrUsuarioPerfilRecurso
{
    /**
     * @var \Admin\Entity\TbPerfil
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Admin\Entity\TbPerfil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="seq_perfil", referencedColumnName="seq_perfil")
     * })
     */
    private $seqPerfil;

    /**
     * @var \Admin\Entity\TbRecurso
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Admin\Entity\TbRecurso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="seq_recurso", referencedColumnName="seq_recurso")
     * })
     */
    private $seqRecurso;

    /**
     * @var \Admin\Entity\TbUsuario
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Admin\Entity\TbUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="seq_usuario", referencedColumnName="seq_usuario")
     * })
     */
    private $seqUsuario;

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
     * @return TbPerfil
     */
    public function getSeqPerfil()
    {
        return $this->seqPerfil;
    }

    /**
     * @param TbPerfil $seqPerfil
     */
    public function setSeqPerfil($seqPerfil)
    {
        $this->seqPerfil = $seqPerfil;
    }

    /**
     * @return TbRecurso
     */
    public function getSeqRecurso()
    {
        return $this->seqRecurso;
    }

    /**
     * @param TbRecurso $seqRecurso
     */
    public function setSeqRecurso($seqRecurso)
    {
        $this->seqRecurso = $seqRecurso;
    }

    /**
     * @return TbUsuario
     */
    public function getSeqUsuario()
    {
        return $this->seqUsuario;
    }

    /**
     * @param TbUsuario $seqUsuario
     */
    public function setSeqUsuario($seqUsuario)
    {
        $this->seqUsuario = $seqUsuario;
    }
}

