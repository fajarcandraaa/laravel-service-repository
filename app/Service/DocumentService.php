<?php

namespace App\Service;

use App\Repositories\DocumentRepository;
use App\Helper\Paginator;
use App\Presentation\Presentation;

class DocumentService {
    protected $documentRepository;

    public function __construct(DocumentRepository $documentRepository) {
        $this->documentRepository = $documentRepository;
    }

    public function insertDocument($payload) {
        $isExist = count($this->documentRepository->findByTitle($payload['title'])); // check existing data before insert
        if ($isExist > 0) {
            return Presentation::serviceResponse(406, 'Duplicate data, not acceptable');
        } else {
            $newDoc = $this->documentRepository->insert($payload); 
            return Presentation::serviceResponse(200, 'Success', $newDoc);;
        }
    }

    public function getListDocuments($paginate) {
        $documents = $this->documentRepository->list($paginate);
        $res = new Paginator(
            $documents->items(),
            $documents->total(),
            $documents->perPage(),
            $documents->currentPage()
        );

        return Presentation::serviceResponse(200, 'Ok', $res);
    }

    public function detailDocument($id) {
        $document = $this->documentRepository->detail($id);
        if (is_null($document)) {
            $resp = Presentation::serviceResponse(404, 'Not Found');
        } else {
            $resp = Presentation::serviceResponse(200, 'Success', $document);
        }
        return $resp;
    }

    public function documentUpdate($id, $payload) {
        foreach ($payload as $k => $v) {
            if ($v == null) {
                unset($payload[$k]);
            }
        }

        $update = $this->documentRepository->update($id, $payload);
        if ($update == false) {
            $resp = Presentation::serviceResponse(404, 'Not Found');
        } else {
            $resp = Presentation::serviceResponse(200, 'Data has been update');
        }

        return $resp;
    }

    public function deleteDocument($id) {
        $document = $this->documentRepository->delete($id);
        if ($document == false) {
            $resp = Presentation::serviceResponse(404, 'Not Found');
        } else {
            $resp = Presentation::serviceResponse(200, 'Data has been deleted');
        }

        return $resp;
    }
}