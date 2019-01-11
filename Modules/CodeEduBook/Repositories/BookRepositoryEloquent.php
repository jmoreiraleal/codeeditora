<?php

namespace CodeEduBook\Repositories;

use CodePub\Criteria\CriteriaTrashedTrait;
use CodePub\Repositories\RepositoryRestoreTrait;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeEduBook\Repositories\BookRepository;
use CodeEduBook\Models\Book;
use CodePub\Validators\BookValidator;

/**
 * Class BookRepositoryEloquent.
 *
 * @package namespace CodePub\Repositories;
 */
class BookRepositoryEloquent extends BaseRepository implements BookRepository
{

    use CriteriaTrashedTrait;
    use RepositoryRestoreTrait;

    protected $fieldSearchable = [
        'title'=>'like',
        'author.name'=>'like'
    ];

    /**
     * @param array $attributes
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $attributes)
    {
       $model =  parent::create($attributes);
       $model->categories()->sync($attributes['categories']);
       return $model;
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed|void
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(array $attributes, $id)
    {
        $model = parent::update($attributes, $id);
        $model->categories()->sync($attributes['categories']);

    }


    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Book::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
