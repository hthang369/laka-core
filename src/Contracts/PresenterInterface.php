<?php
namespace Laka\Core\Contracts;

/**
 * Interface PresenterInterface
 * @package Laka\Core\Contracts
 * @author Anderson Andrade <contato@andersonandra.de>
 */
interface PresenterInterface
{
    /**
     * Prepare data to present
     *
     * @param $data
     *
     * @return mixed
     */
    public function present($data);
}
