<?php

namespace CodePub\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindByTitleCriteria.
 *
 * @package namespace CodePub\Criteria;
 */
class FindByTitleCriteria implements CriteriaInterface
{
    private $title;

    /**
     * FindByTitleCriteria constructor.
     */
    public function __construct($title)
    {
        $this->title = $title;
    }


    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('title','LIKE',"%{$this->title}%");
    }
}
