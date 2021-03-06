<?php

namespace CodeEduBook\Http\Requests;

use Auth;
use CodeEduBook\Repositories\BookRepository;
use CodeEduBook\Http\Requests\BookCreateRequest;

class BookUpdateRequest extends BookCreateRequest
{
    /**
     * @var BookRepository
     */
    private $repository;

    /**
     * BookUpdateRequest constructor.
     * @param BookRepository $repository
     */
    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $id = (int) $this->route('book');

        if($id == 0)
        {
            return false;
        }

        /** @var TYPE_NAME $book */
        $book = $this->repository->find($id);
        return $book->author_id == Auth::user()->id;
    }

}
