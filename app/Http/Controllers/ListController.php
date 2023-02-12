<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Lists;
use App\Services\ListService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    protected ListService $service;

    public function __construct(ListService $service)
    {
        $this->service = $service;
    }

    /**
     * Отображает страницу со всеми списками
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $lists = Lists::where('user_id', Auth::id())->get();
        return view('lists.all', ['lists' => $lists]);
    }

    /**
     * Отображает страницу создания нового списка
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('lists.create');
    }

    /**
     * Сохраняет новый список
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validation = $this->service->ValidateData($request);
        if ($validation->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validation->messages()
            ]);
        }

        $this->service->StoreData($request);

        return response()->json([
            'status' => 1
        ]);
    }

    /**
     * Отображает определенный список
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $id)
    {
        $list = Lists::find($id);
        $articles =  Article::where('list_id', $id);

        if($request->q)
        {
            $articles->where('text', 'like', '%' . $request->q . '%');
        }

        if($request->t)
        {
            $filters = explode(',', $request->t);
            foreach ($filters as $filter)
                $articles->where('tags', 'like', '%'. $filter .'%');
        }

        $articles = $articles->get();

        return view('lists.view', [
            'list' => $list,
            'articles' => $articles,
            'q' => $request->q,
            't' => $request->t
        ]);
    }

    /**
     * Страница редактирования определенного списка
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $list = Lists::find($id);
        $articles = Article::where('list_id', $id)->get();

        return view('lists.edit', ['list' => $list, 'articles' => $articles]);
    }

    /**
     * Обновляет определенный список
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validation = $this->service->ValidateData($request);
        if ($validation->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validation->messages()
            ]);
        }

        $this->service->UpdateData($request, $id);

        return response()->json([
            'status' => 1
        ]);
    }

    /**
     * Удаляет список
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->service->DeleteData($id);
        return back();
    }

    /**
     * Удаляет пункт
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteArticle(Request $request)
    {
        $this->service->DeleteArticle($request);

        return response()->json([
            'status' => 1
        ]);
    }

    /**
     * Удаляет картинку пункта
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage(Request $request)
    {
        $this->service->DeleteImage($request);

        return response()->json([
            'status' => 1
        ]);
    }
}
