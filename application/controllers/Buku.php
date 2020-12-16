<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');


class Buku extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Buku_model');
    }

    public function index_get()
    {
        $isbn = $this->get('isbn');

        if ($isbn === null) {
            $buku = $this->Buku_model->getBuku();
        } else {
            $buku = $this->Buku_model->getBuku($isbn);
        }

        if ($buku) {
            $this->response([
                'status' => true,
                'message' => $buku
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => $isbn . ' tidak ditemukan'
            ], RestController::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $isbn = $this->delete('isbn');

        if ($isbn === null) {
            $this->response([
                'status' => false,
                'message' => 'permintaan ini membutuhkan isbn'
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            if ($this->Buku_model->deleteBuku($isbn) > 0) {
                $this->response([
                    'status' => true,
                    'isbn' => $isbn,
                    'message' => 'berhasil dihapus'
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'isbn tidak ada yang cocok'
                ], RestController::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'isbn' => $this->post('isbn'),
            'judul' => $this->post('judul'),
            'penulis' => $this->post('penulis'),
            'penerbit' => $this->post('penerbit'),
        ];

        if ($this->Buku_model->createBuku($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'berhasil menambahkan data'
            ], RestController::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'gagal menambahkan data'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $isbn = $this->put('isbn');
        $data = [
            'isbn' => $this->put('isbn'),
            'judul' => $this->put('judul'),
            'penulis' => $this->put('penulis'),
            'penerbit' => $this->put('penerbit'),
        ];

        if ($this->Buku_model->updateBuku($data, $isbn) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data berhasil diubah'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'data gagal diubah'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }
}
