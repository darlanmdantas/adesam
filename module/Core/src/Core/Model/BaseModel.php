<?php

/**
 * Quali-A / Etiquetagem (http://www.quali-a.com)
 *
 * @link      http://etiquetagem.quali-a.com para o repositório do sistema
 * @copyright Copyright (c) 2005-2014 Aplicação feita com Zend Framework para. (http://www.quali-a.com)
 * @license   Todos os direitos reservados
 */

namespace Core\Model;

use Core\Service\ModelService;

class BaseModel extends ModelService
{
    protected $entity;

    /**
     * função entity
     * @param $entity
     * @return $this
     */
    public function setEntity($entity){
        $this->entity = $entity;
        return $this;
    }

    /**
     * função Carrega toda os itens
     * @return mixed
     */
    public function findAll()
    {
        $repository = $this->getEntityManager()->getRepository($this->entity);
        return $repository->findAll();
    }

    /**
     * função Carrega todos os itens passando o id com oparametro
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $data = $this->getEntityManager()->find($this->entity, $id);
        return $data;
    }

    /**
     * função save
     * @param $data
     */
    public function save($data)
    {
        $repository = $this->getEntityManager();
        $repository->persist($data);
        $repository->flush();
    }

    /**
     * função update
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id)
    {
        $repository = $this->getEntityManager();

        $update = $repository->find($this->entity, $id);
        $update->exchangeArray($data->getArrayCopy());
        $repository->flush();

        return $data;
    }

    /**
     * função delete
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $repository = $this->getEntityManager();

        $delete = $repository->find($this->entity, $id);
        try{
            $repository->remove($delete);
            $repository->flush();
        } catch(\Doctrine\DBAL\DBALException $e) {
            $this->flashMessenger()->setNamespace('danger')->addMessage('Não foi possível excluir o(a) ' . $this->label . '!');
        }
        return true;
    }

    /**
     * função Conta todos os itens
     * @return mixed
     */
    public function count()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('count(e)')->from($this->entity, 'e');
        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * função Carrega os itens passando um campo e o valor
     * Ex. array($attributes => $value)
     * @param $array
     * @return mixed
     */
    public function getByAttributes($array)
    {
        $data = $this->getEntityManager()->getRepository($this->entity)->findBy($array);
        return $data;
    }

    /**
     * função utilizada para campos do tipo combobox
     * @param $attributeId
     * @param $attributeLabel
     * @return array
     */
    public function getAllItensToSelect($attributeId,$attributeLabel)
    {
        $repository = $this->getEntityManager()->getRepository($this->entity);
        $data = $repository->findAll();

        $obj = [];
        foreach ($data as $key => $value) {
            $obj[$value->$attributeId] = $value->$attributeLabel;
        }
        return $obj;
    }

    /**
     * função que retorna todos os ítens para a combobox
     * @param $attributes
     * @param $attributeId
     * @param $attributeLabel
     * @return array
     */
    public function getAllItensToSelectByAttributes($attributes, $attributeId, $attributeLabel) {
        $data = $this->getEntityManager()->getRepository($this->entity)->findBy($attributes);

        $obj = [];
        foreach ($data as $key => $value) {
            $obj[$value->$attributeId] = $value->$attributeLabel;
        }
        return $obj;
    }

    /**
     * função retorna todos os ítens para a combobox via json
     * @param $attributes
     * @param $attributeId
     * @param $attributeLabel
     * @return array
     */
    public function getAllItensToSelectByAttributesJsonReturn($attributes, $attributeId, $attributeLabel) {
        $data = $this->getEntityManager()->getRepository($this->entity)->findBy($attributes);

        $obj = [];
        foreach ($data as $key => $value) {
            $obj[] = array($attributeId => $value->$attributeId,  $attributeLabel => $value->$attributeLabel);
        }
        return $obj;
    }
}