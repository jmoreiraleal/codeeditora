<?php

namespace CodeEduBook\Repositories;

use CodePub\Criteria\CriteriaTrashedTrait;
use CodePub\Repositories\BaseRepositoryTrait;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeEduBook\Models\Category;

/**
 * Class CategoryRepositoryEloquent.
 *
 * @package namespace CodePub\Repositories;
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{

    use BaseRepositoryTrait;
    //trait que implementa os metodos para trazer o lixo
    use CriteriaTrashedTrait;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param $column
     * @param null $key
     * @return
     */
    public function listsWithMutators($column, $key = null)
    {
        /** @var Collection $collection */
        $collection = $this->all();
        return $collection->pluck($column,$key);
    }


}
