<?php
namespace App\Repositories;

use Illuminate\Support\Arr;

/**
 * Abstract Respository
 *
 * @package App\Repositories
 */
abstract class RepositoryAbstract
{

    /**
     * Global variable model
     */
    protected $model;

    /**
     * Function construct
     *
     * @param $_model
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get model
     * @return string
     */
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }
}
