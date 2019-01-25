<?php

namespace CodeEduUser\Http\Controllers;


use CodeEduUser\Http\Requests\UserRequest;
use CodeEduUser\Repositories\UserRepository;
use Session;
use URL;

class UsersController extends Controller
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * usersController constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
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

        //$users = User::onlyTrashed()->paginate(10);
        $users = $this->repository->paginate(10);
        return view('codeeduuser::users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('codeeduuser::users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $this->repository->create($request->all());

        //manter o usuário na anterior
        $url = $request->get('redirect_to',route('codeeduuser.users.index'));
        $request->session()->flash('message','Usuário cadastrado com sucesso');
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
        $user = $this->repository->find($id);
        return view('codeeduuser::users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request,$id)
    {
        $this->repository->update($request->all(),$id);

        //manter o usuário na anterior
        $url = $request->get('redirect_to',route('codeeduuser.users.index'));
        $request->session()->flash('message','Usuário alterado com sucesso');
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
        Session::flash('message','Usuário excluído com sucesso');
        return redirect()->to(URL::previous());
    }
}
