<?php

namespace App\Repositories;

use App\Models\Documents;
use Illuminate\Support\Str;

class DocumentRepository {


    public function __construct(Documents $document) {
        $this->document = $document;
    }

    // findByTitle is function to get data by title
    public function findByTitle($title) {
        $data = $this->document
                ->where('title', $title)
                ->get();
        return $data;
    }

    // insert is function to insert new data
    public function insert($payload) {
        $insert = $this->document->create([
            'id'    => Str::uuid()->toString(), // use uuid as id for more secure, because increment number is easy to predicted
            'title' => $payload['title'],
            'body'  => $payload['body']
        ]);

        return $insert;
    }

    public function list($paginate) {
        $data = $this->document
                ->orderBy($paginate['order_by'], $paginate['order_method'])
                ->paginate($paginate['per_page'],['*'],'page',$paginate['page']);
        return $data;
    }

    public function detail($id) {
        $document = $this->document->find($id);
        return $document;
    }

    public function update($id, $payload) {
        $updateDocument = $this->document
                            ->where('id', $id)
                            ->update($payload);

        return $updateDocument;
    }

    public function delete($id) {
        $document = $this->document
                    ->where('id', $id)
                    ->delete();

        return $document;
    }


}