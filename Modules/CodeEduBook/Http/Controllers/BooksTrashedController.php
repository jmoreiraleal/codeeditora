<?php

namespace CodeEdubook\Http\Controllers;

use Illuminate\Http\Request;
use CodeEduBook\Repositories\BookRepository;
use Illuminate\Routing\Controller;

/**
 * Class BooksController.
 *
 * @package namespace CodePub\Http\Controllers;
 */
class BooksTrashedController extends Controller
{
    /**
     * @var BookRepository
     */
    protected $repository;

    /**
     * BooksController constructor.
     *
     * @param BookRepository $repository
     */
    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $books = $this->repository->onlyTrashed()->paginate(10);
        return view('codeedubook::trashed.books.index',compact('books','search'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $this->repository->onlyTrashed();
        $book = $this->repository->find($id);

        return view('codeedubook::trashed.books.show',compact('book'));
    }

    public function update(Request $request,$id)
    {
        $this->repository->onlyTrashed();
        $this->repository->restore($id);

        $url = $request->get('redirect_to',route('trashed.books.index'));
        $request->session()->flash('message','Livro restaurado com sucesso');

        return redirect()->to($url);
    }

}
