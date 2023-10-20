<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;

class PostsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Post::where("worker_id",auth("worker")->id())->get(["worker_id","price","content","created_at","updated_at"]);
    }

}
