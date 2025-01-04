<?php

namespace App\Repositories;

use App\Contracts\Repositories\BlogInterface;
use App\Http\Requests\Request;
use App\Models\Blog;

class BlogRepository implements BlogInterface
{
    public function __construct(
       private readonly Blog $blogcode
    )
    {
    }

    public function add(object $request): bool
    {
        $data = $request->only([
            'cat_id',
            'title',
            'cat_id',
            'description',
          	'image',
            'slug',
            'meta_title',
            'meta_discription',
            'keywords',
            'created_at',
            'updated_at'
        ]);
        $blogcode = new Blog();
        $blogcode->title            = $request->title;
        $blogcode->meta_title       = $request->meta_title;
        $blogcode->meta_discription = $request->meta_discription;
        $blogcode->keywords         = $request->keywords;
        $blogcode->slug             = strtolower($request->slug);
        $blogcode->cat_id           = $request->cat_id;
        $blogcode->description      = $request->description;
        $blogcode->image            = $request->image_file;
        return $blogcode->save();
    }

    public function update(object $request): bool
    {
        // Extract only the relevant data from the request
        $data = $request->only([
            'id',
            'title',
            'cat_id',
            'description',
            'meta_title',
            'meta_discription',
            'keywords',
          	'image',
            'slug',
            'created_at',
            'updated_at'
        ]);

        $blogcode = Blog::find($data['id']);
        if ($blogcode) {
            $update_data = [
                'title'            => $request->title,
                'meta_title'       => $request->meta_title,
                'meta_discription' => $request->meta_discription,
                'keywords'         => $request->keywords,
                'description'      => $request->description,
                'slug'             =>  strtolower($request->slug),
              	'created_at'       => now(),
                'updated_at'       =>now()
            ];
            if (!empty($request->image_file)) {
                $update_data['image'] = $request->image_file;
            }
            if (!empty($request->cat_id)) {
                $update_data['cat_id'] = $request->cat_id;
            }
            return $blogcode->update($update_data);
        }

        // If no record was found, return false
        return false;
    }

    public function updateData(string $model, string $id, string $lang, string $key, string $value):bool
    {
        $this->blogcode->updateOrInsert(
            [
                'Hsncodeable_type' => $model,
                'Hsncodeable_id' => $id,
                'locale' => $lang,
                'key' => $key
            ],
            [
                'value' => $value
            ]
        );
        return true;
    }
    public function delete(object $request): bool
    {
        $id = $request->input('blogId');
        $hsn = Blog::find($id);

        if (!$hsn) {
            return false;
        }

        $hsn->status = 0;
        $updated = $hsn->save();

        return $updated;
    }

}
