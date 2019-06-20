<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePostFormRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;

        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->post->with('user.tenant')->latest()->paginate();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * @param  StoreUpdatePostFormRequest  $request
     * @return mixed
     */
    public function store(StoreUpdatePostFormRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $name = Str::kebab($request->title);
            $extension = $request->image->extension();
            $nameImage = "{$name}.$extension";
            $data['image'] = $nameImage;

            $upload = $request->image->storeAs('posts', $nameImage);
            if (!$upload) {
                return redirect()->back()->with('errors', ['Falha no upload']);
            }
        }

        $post = $request->user()
            ->posts()
            ->create($data);

        return redirect()
            ->back()
            ->withSuccess('Cadastro realizado com sucesso!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$post = $this->post->find($id)) {
            return redirect()->back();
        }

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$post = $this->post->find($id)) {
            return redirect()->back();
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdatePostFormRequest $request, $id)
    {
        $post = $this->post->find($id);

        $post->update($request->all());

        return redirect()
            ->back()
            ->withSuccess('Atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
