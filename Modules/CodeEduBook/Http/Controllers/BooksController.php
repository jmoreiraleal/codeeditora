<?php

namespace CodeEduBook\Http\Controllers;


use CodeEduBook\Http\Requests\BookCreateRequest;
use CodeEduBook\Http\Requests\BookUpdateRequest;
use CodeEduBook\Repositories\BookRepository;
use CodeEduBook\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Session;
use URL;

/**
 * Class BooksController.
 *
 * @package namespace CodePub\Http\Controllers;
 */
class BooksController extends Controller
{
    /**
     * @var BookRepository
     */
    protected $repository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * BooksController constructor.
     *
     * @param BookRepository $repository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(BookRepository $repository,CategoryRepository $categoryRepository)
    {
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $books = $this->repository->paginate(10);
        return view('codeedubook::books.index',compact('books','search'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->lists('name','id');

        return view('codeedubook::books.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BookCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(BookCreateRequest $request)
    {
        $data = $request->all();

        /**
         * criando no indice no array da requisicão
         * @var id do usuario logado
         */
        $data['author_id'] = \Auth::user()->id;
        $this->repository->create($data);

        //manter o usuário na anterior
        $url = $request->get('redirect_to',route('books.index'));
        $request->session()->flash('message','Livro cadastrado com sucesso');
        return redirect()->to($url);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $book,
            ]);
        }

        return view('codeedubook::books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = $this->repository->find($id);
        $this->categoryRepository->withTrashed();
        /** @var mutator para categorias exibe inativa na frente do nome $categories */
        $categories = $this->categoryRepository->listsWithMutators('name_trashed','id');
        return view('codeedubook::books.edit', compact('book','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BookUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(BookUpdateRequest $request, $id)
    {
        $data = $request->except(['author_id']);
        $this->repository->update($data,$id);

        //manter o usuário na anterior
        $url = $request->get('redirect_to',route('books.index'));
        $request->session()->flash('message','Livro alterado com sucesso');
        return redirect()->to($url);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        Session::flash('message','Livro excluído com sucesso');
        return redirect()->to(URL::previous());
    }
}
