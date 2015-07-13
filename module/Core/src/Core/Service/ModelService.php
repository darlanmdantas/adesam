<?php

/**
 * Quali-A / Etiquetagem (http://www.quali-a.com)
 *
 * @link      http://etiquetagem.quali-a.com para o repositório do sistema
 * @copyright Copyright (c) 2005-2014 Aplicação feita com Zend Framework para. (http://www.quali-a.com)
 * @license   Todos os direitos reservados
 */

namespace Core\Service;

class ModelService extends BaseService
{

    /**
     * @param $data
     * @return mixed
     */
    protected function removeInputFilter($data)
    {
        foreach ($data as $key => $value) {
            if ($key == 'inputFilter') {
                unset($data[$key]);
            }
        }
        return $data;
    }

    /**
     * @param $data
     * @param $key
     * @param $value
     * @return mixed
     */
    public function prepareDataToSelectInput($data, $key, $value)
    {
        $preparedData[0] = '';
        if (sizeof($data) > 0) {
            foreach ($data as $k => $v) {
                $preparedData[$v->{$key}] = $v->{$value};
            }
        }
        return $preparedData;
    }
}