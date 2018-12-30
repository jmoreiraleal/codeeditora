<?php

namespace CodePub\Repositories;

trait BaseRepositoryTrait
{
    /**
     * @param $column
     * @param null $key
     * @return mixed
     */
    public function lists($column, $key = null)
    {
        $this->applyCriteria();

        return $this->model->pluck($column, $key);
    }
}