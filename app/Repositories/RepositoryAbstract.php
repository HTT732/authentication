<?php
namespace App\Repositories;


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

    /**
     * delete user
     * @param $id
     * @return boolean
     */
    public function delete($id) {
        return $this->model->findOrFail($id)->delete();
    }

    /**
     * Get data by id
     * @param $id
     * @return boolean
     */
    public function findById($id) {
        return $this->model->findOrfail($id);
    }

    /**
     * Get all data from users table
     * @param integer $per_page
     * @return boolean
     */
    public function getDataPaginate($per_page) {
        return $this->model->paginate($per_page);
    }
}
