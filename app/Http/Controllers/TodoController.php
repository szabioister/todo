<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TodoController extends Controller
{
	public function __construct(Request $request)
	{
		$this->middleware('auth');
		$visible = session()->get('visible',false);
		if(!$visible) {
            session()->put('visible','1');
        }
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$visible = session()->get('visible',false);
		if($visible == '0') {
			$result = Auth::user()->todo()->where('status','0')->orderBy('status', 'ASC')->orderBy('created_at', 'DESC')->orderBy('status_date', 'DESC')->get();
		} else {
			$result = Auth::user()->todo()->orderBy('status', 'ASC')->orderBy('created_at', 'DESC')->orderBy('status_date', 'DESC')->get();
		}
		
		if(!$result->isEmpty()) {
			return view('todo.dashboard',['todos'=>$result, 'keresoszo'=>'', 'visible'=>session()->get('visible',false)]);
		} else {
			return view('todo.dashboard',['todos'=>false, 'keresoszo'=>'', 'visible'=>session()->get('visible',false)]);
		}
    }
	
	public function search(Request $request)
    {
		$visible = session()->get('visible',false);
		if($visible == '0') {
			$result = Auth::user()->todo()->where('status','0')->where('cim', 'like', '%' . $request->keresoszo . '%')->orWhere('description', 'like', '%' . $request->keresoszo . '%')->orderBy('status', 'ASC')->orderBy('created_at', 'DESC')->orderBy('status_date', 'DESC')->get();
		} else {
			$result = Auth::user()->todo()->where('cim', 'like', '%' . $request->keresoszo . '%')->orWhere('description', 'like', '%' . $request->keresoszo . '%')->orderBy('status', 'ASC')->orderBy('created_at', 'DESC')->orderBy('status_date', 'DESC')->get();
		}
		
		if(!$result->isEmpty()) {
			return view('todo.dashboard',['todos'=>$result, 'keresoszo'=>$request->keresoszo, 'visible'=>session()->get('visible',false)]);
		} else {
			return view('todo.dashboard',['todos'=>false, 'keresoszo'=>$request->keresoszo, 'visible'=>session()->get('visible',false)]);
		}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.addtodo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$this->validator($request->all())->validate();
		$req = $request->all();
		
		$file = $request->file('file');
		if(!empty($file)) {
			$name = Storage::putfile('files', $file);
			$req['file'] = $name;
		}

		if(Auth::user()->todo()->Create(
			$req
		)) {
			return redirect('todo');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return view('todo.todo',['todo' => $todo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        return view('todo.edittodo',['todo' => $todo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
		
        $this->validator($request->all())->validate();
		
		
		$req = $request->all();
		
		$file = $request->file('file');
		if(!empty($file)) {
			$name = Storage::putfile('files', $file);
			$req['file'] = $name;
		}
		
		if($todo->fill($req)->save()) {
			return $this->show($todo);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        if($todo->delete()) {
			return back();
		}
    }
	
	public function close(Todo $todo)
    {
		$todo->status = 1;
		$todo->status_date = \Carbon\Carbon::now();
		$todo->save();
		
		return redirect('todo');
    }
	
	public function setvisible(Request $request)
    {
		if(session()->get('visible',false) == '1') {
			session()->put('visible','0');
		} else {
			session()->put('visible','1');
		}
		
		return redirect('todo');
    }
	
	protected function validator(array $request)
	{
		return Validator::make($request, [
			'cim' => 'required',
			'file' => 'max:5000000|mimes:jpg,jpeg,pdf,xml'
		]);
	}
}
