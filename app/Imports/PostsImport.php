<?php

namespace App\Imports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\ToModel;

class PostsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $post = new Post([
            "worker_id" => $row[0],
            "price" => $row[1],
            "content" => $row[2],
        ]);

        return $post;
    }
}


