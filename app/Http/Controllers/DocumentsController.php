<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Service\DocumentService;
use App\Presentation\Presentation;
use Illuminate\Validation\ValidationException;

class DocumentsController extends Controller
{
    protected $documentService;

    public function __construct(DocumentService $documentService) {
        $this->middleware('auth:api');
        $this->documentService = $documentService;
    }

    // newDocument is controller to hande create new document
    public function newDocument(Request $request) {
        
        $payload = $request->only([
            'title',
            'body',
        ]);

        $validator = Validator::make($payload, [ // this line is for validate the request body
            'title' => 'string|required',
            'body'  => 'string|required'
        ]);
        if ($validator->fails()) {
            $val = $validator->errors();
            return Presentation::presentResponse(422, 'Unprocessable Content', $val); // if no body request or request with wrong type
        }


        try {
            $data = $this->documentService->insertDocument($payload); // start insert process
            switch ($data['code']) {
                case 200:
                    return Presentation::presentResponse($data['code'], $data['message'], $data['primary_data']);
                default:
                    return Presentation::presentResponse($data['code'], $data['message']);
            }
        } catch (\Exception $e) {
            return Presentation::presentResponse(500, $e->getMessage());
        }
    }

    // listDocument is controller to hande get all data from documents table
    public function listDocument(Request $request) {
        try {
            // validate parameter
            $request->validate([
                'page' => 'nullable|integer',
                'per_page' => 'nullable|integer',
                'order_by' => 'nullable|string',
                'order_method' => 'nullable|in:asc,desc',
            ]);
        } catch (ValidationException $e) {
            return Presentation::presentResponse(422, 'Unprocessable Content'); 
        }

        $page           = $request->input('page') == null ? 1 : $request->input('page');
        $perPage        = $request->input('per_page') == null ? 10 : $request->input('per_page');
        $orderBy        = $request->input('order_by') == null ? 'created_at' : $request->input('order_by');
        $orderMethod    = $request->input('order_method') == null ? 'desc' : $request->input('order_method');
        $pagination     = Presentation::paginateRequest($page, $perPage, $orderBy, $orderMethod); // set paginatior request

        try {
            $data = $this->documentService->getListDocuments($pagination);
            switch ($data['code']) {
                case 200:
                    return Presentation::presentResponse($data['code'], $data['message'], $data['primary_data']);
                default:
                    return Presentation::presentResponse($data['code'], $data['message']);
            }
            return Presentation::presentResponse($data['code'], $data['message'], $data['primary_data']);
        } catch (\Exception $e) {
            return Presentation::presentResponse(500, $e->getMessage());
        }
    }

    // getDetailDocumentById is controller to hande get detail data from documents table by document's id
    public function getDetailDocumentById($id) {
        $rules = [
            'id' => 'required|uuid',
        ];
        $validator = Validator::make(['id' => $id], $rules);
        if ($validator->fails()) {
            return Presentation::presentResponse(422, 'Unprocessable Content'); 
        }

        try {
            $data = $this->documentService->detailDocument($id);
            switch ($data['code']) {
                case 200:
                    return Presentation::presentResponse($data['code'], $data['message'], $data['primary_data']);
                default:
                    return Presentation::presentResponse($data['code'], $data['message']);
            }
        } catch (\Exception $e) {
            return Presentation::presentResponse(500, $e->getMessage());
        }
    }

    // updateDocumentById is controller to hande update data in documents table by document's id
    public function updateDocumentById(Request $request, $id) {
        $rules = [
            'id'    => 'required|uuid',
        ];
        $payload = $request->only([
            'title',
            'body',
        ]);

        $validator = Validator::make([
            'id' => $id
        ], $rules);
        if ($validator->fails()) {
            $val = $validator->errors();
            return Presentation::presentResponse(422, 'Unprocessable Content', $val); // if no body request or request with wrong type
        }

        try {
            $data = $this->documentService->documentUpdate($id, $payload);
            switch ($data['code']) {
                case 200:
                    return Presentation::presentResponse($data['code'], $data['message']);
                default:
                    return Presentation::presentResponse($data['code'], $data['message']);
            }
        } catch (\Exception $e) {
            return Presentation::presentResponse(500, $e->getMessage());
        }
    }

    // documentDeleteById is controller to hande delete or destroy data in documents table by document's id
    public function documentDeleteById($id) {
        $rules = [
            'id' => 'required|uuid',
        ];
        $validator = Validator::make(['id' => $id], $rules);
        if ($validator->fails()) {
            return Presentation::presentResponse(422, 'Unprocessable Content'); 
        }

        try {
            $data = $this->documentService->deleteDocument($id);
            switch ($data['code']) {
                case 200:
                    return Presentation::presentResponse($data['code'], $data['message']);
                default:
                    return Presentation::presentResponse($data['code'], $data['message']);
            }
        } catch (\Exception $e) {
            return Presentation::presentResponse(500, $e->getMessage());
        }
    }
}