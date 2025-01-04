<?php

namespace App\Repositories;

use App\Contracts\Repositories\BlogCategoryInterface;
use App\Http\Requests\Request;
use App\Models\BlogCategory;

class BlogCategoryRepository implements BlogCategoryInterface
{
    public function __construct(
       private readonly BlogCategory $Hsncode
    )
    {
    }

    public function add(object $request): bool
    {
        $data = $request->only([
            'id',
            'name',
            'slug',
            'created_at',
          	'updated_at',
        ]);
        $hsncode = new BlogCategory();
        $hsncode->fill($data);
        return $hsncode->save();
    }

    public function update(object $request): bool
    {
        // Extract only the relevant data from the request
        $data = $request->only([
            'id',
            'name',
            'slug',
            'created_at',
          	'updated_at',
        ]);

        // Find the Hsncode model by ID
        $hsn = BlogCategory::find($data['id']);

        if ($hsn) {
            // Update the Hsncode model with the new data
            return $hsn->update([
                'name' => $data['name'],
                'slug' => $data['slug'],
              	'created_at' => now(),
                'updated_at'=>now()
            ]);
        }

        // If no record was found, return false
        return false;
    }

    public function updateData(string $model, string $id, string $lang, string $key, string $value):bool
    {
        $this->Hsncode->updateOrInsert(
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
        $hsn = BlogCategory::find($id); 
       
        if (!$hsn) {
            return false; 
        }

        $hsn->status = 0;
        $updated = $hsn->save(); 
    
        return $updated;
    }
    
}
