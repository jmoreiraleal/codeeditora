<?php

namespace CodeEduBook\Http\Controllers;


use CodeEduBook\Http\Requests\CategoryRequest;
use CodeEduBook\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Session;
use URL;

class CategoriesController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $repository;

    /**
     * CategoriesController constructor.
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {

        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //$categories = Category::onlyTrashed()->paginate(10);
        $categories = $this->repository->paginate(10);
        return view('codeedubook::categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('codeedubook::categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $this->repository->create($request->all());

        //manter o usuário na anterior
        $url = $request->get('redirect_to',route('categories.index'));
        $request->session()->flash('message','Categoria cadastrada com sucesso');
        return redirect()->to($url);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->repository->find($id);
        return view('codeedubook::categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request,$id)
    {
        $this->repository->update($request->all(),$id);

        //manter o usuário na anterior
        $url = $request->get('redirect_to',route('categories.index'));
        $request->session()->flash('message','Categoria alterada com sucesso');
        return redirect()->to($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        Session::flash('message','Categoria excluída com sucesso');
        return redirect()->to(URL::previous());
    }
}
