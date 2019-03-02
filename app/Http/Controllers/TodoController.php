<?php

namespace App\Http\Controllers;

use App\Dtos\Response\Todo\TodoDto;
use App\Dtos\Response\Todo\TodoListDto;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class TodoController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = (int)$request->get('page', 1);
        $page_size = (int)$request->get('page_size', 10);

        //Product::resolveConnection()->getPaginator()->setCurrentPage($page - 1);
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });


        // Some interesting code is in \Eloquent\Builder.php
        // By reading the Framework source code I see the page is set to $page from input Request,
        // page_size is set to paginate(page_size)
        // that means we do not have to setCurrentPageResolver because it works
        // if we sent ?page= in the url
        $todos = Todo::orderBy('created_at', 'desc')
            ->paginate($page_size, $columns = ['id', 'title', 'created_at', 'updated_at']);

        return $this->sendSuccessResponse(TodoListDto::build($todos, $request->path()));
    }

    // TODO: Select manually
    public function getAllSimple(Request $request)
    {
        $page = (int)$request->get('page', 1);
        $page_size = (int)$request->get('page_size', 10);

        //Product::resolveConnection()->getPaginator()->setCurrentPage($page - 1);
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });


        $todos = Todo::orderBy('created_at', 'desc')
            ->paginate($page_size);
        $todoDtos = [];
        foreach ($todos->items() as $key => $product) {
            $todoDtos[] = TodoDto::build($product);
        }

        return response()->json($todoDtos, 200);
    }

    public function getCompleted(Request $request)
    {
        $page = (int)$request->get('page', 1);
        $page_size = (int)$request->get('page_size', 10);

        //Product::resolveConnection()->getPaginator()->setCurrentPage($page - 1);
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });


        // By reading the Framework source code I see the page is set to $page from input Request,
        // page_size is set to paginate(page_size)
        // that means we do not have to setCurrentPageResolver because it works
        // if we sent ?page= in the url
        $todos = Todo::where('completed', true)
            ->orderBy('created_at', 'desc')
            ->paginate($page_size);

        return $this->sendSuccessResponse(TodoListDto::build($todos, $request->path()));
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = Todo::find($id);
        if ($todo == null)
            return $this->sendErrorResponse('Todo not found');
        else
            return $this->sendSuccessResponse(TodoDto::build($todo, true));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->only(['title','description','completed']);
        $todo = new Todo;
        $todo->title = $request->title;
        $todo->description = $request->get('description', '');
        $todo->completed = $request->completed;
        $todo->save();
        return $this->sendSuccessResponse(TodoDto::build($todo, true), "Todo created successfully");
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id /*Todo $todo*/)
    {

        $todo = Todo::find($id);
        if ($todo == null)
            return $this->sendErrorResponse('Todo not found');

        $data = $request->only(['title', 'description', 'completed']);
        $todo->title = $data['title'];
        $todo->description = $data['description'];
        $todo->completed = $data['completed'];
        $todo->save();
        return $this->sendSuccessResponse(TodoDto::build($todo, true), "Todo updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Todo::find($id);
        $todo->delete();
        return $this->sendSuccessResponse(null, $messages = 'Todo deleted successfully');
    }

    public function destroyAll()
    {
        $deletedTodos = Todo::whereNotNull('id')->delete();
        // $deletedTodos = Todo::truncate();
        return $this->sendSuccessResponse(null, 'Deleted all todos successfully');
    }
}
