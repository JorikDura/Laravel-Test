<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Lists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ListService
{
    /**
     * Добавляет данные в бд (таблица lists и article)
     * @param Request $request
     * @return void
     */
    public function StoreData(Request $request): void
    {
        $list = new Lists([
            'title' => $request->title,
            'user_id' => Auth::id(),
        ]);

        $list->save();

        $items = $request->item;

        $this->StoreArticles($items, $list->id);
    }

    /**
     * Обновляет уже существующие записи и добавляет новые
     * @param Request $request
     * @param $id
     * @return void
     */
    public function UpdateData(Request $request, $id): void
    {
        $list = Lists::find($id);
        $articles = Article::where('list_id', $id)->get();

        $items = $request->item;

        $list->title = $request->title;

        $list->save();

        foreach ($articles as $article) {
            foreach ($items as $key => $item) {
                if ($article->id == $key) {
                    $article->text = $item['text'];
                    $article->tags = $item['tags'];

                    if (array_key_exists('picture', $item)) {
                        if (!empty($article->image)) {
                            Storage::delete('public/files/' . $article->image);
                        }

                        $file = $item['picture'];
                        $file_name = $file->getClientOriginalName();
                        $article->image = $file_name;
                        $file->storeAs('public/files/', $file_name);
                    }

                    $article->save();
                    unset($items[$key]);
                }
            }
        }

        $this->StoreArticles($items, $list->id);
    }

    /**
     * Валидация данных
     * @param Request $request
     * @return \Illuminate\Validation\Validator
     */
    public function ValidateData(Request $request): \Illuminate\Validation\Validator
    {
        return Validator::make($request->all(), [
            'title' => 'required|max:50',
            'item.*.text' => 'required|max:100',
            'item.*.picture' => 'mimes:jpg,png,jpeg',
        ], [
            'title.max' => 'Поле "Наименование списка" должно быть меньше чем :max',
            'title.required' => 'Поле "Наименование списка" обязательно',
            'item.*.tex.max' => 'Поле "Пункт" должно быть меньше чем :max',
            'item.*.text.required' => 'Поле "Пункт" обязательно',
            'item.*.picture' => 'Что это? Мне нужны только картинки!'
        ]);
    }

    /**
     * Удаляет лист из бд
     * @param $id
     * @return void
     */
    public function DeleteData($id): void
    {
        $list = Lists::find($id);
        $articles = Article::where('list_id', $id)->get();

        foreach ($articles as $article) {
            //если есть картинка - удаляем
            if (!empty($article->image)) {
                Storage::delete('public/files/' . $article->image);
            }
        }

        $list->delete();
    }

    /**
     * Удаляет определенный пункт из бд
     * @param Request $request
     * @return void
     */
    public function DeleteArticle(Request $request): void
    {
        DB::table('articles')->delete($request->id);
    }

    /**
     * Удаляет картинку у пункта
     * @param Request $request
     * @return void
     */
    public function DeleteImage(Request $request): void
    {
        $article = Article::find($request->id);
        Storage::delete('public/files/' . $article->image);
        $article->image = "";
        $article->save();
    }

    /**
     * Добавляет пункты в бд
     * @param $items
     * @param $listId
     * @return void
     */
    protected function StoreArticles($items, $listId): void
    {
        foreach ($items as $key => $item) {
            $article = new Article([
                'list_id' => $listId,
                'text' => $item['text'],
                'tags' => $item['tags']
            ]);

            //если картинка существует - добавляем
            if (array_key_exists('picture', $item)) {
                $file = $item['picture'];
                $file_name = $file->getClientOriginalName();
                $article->image = $file_name;
                $file->storeAs('public/files/', $file_name);
            }

            $article->save();
        }
    }
}
