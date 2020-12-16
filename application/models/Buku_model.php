<?php

class Buku_model extends CI_Model
{
    public function getBuku($isbn = null)
    {
        if ($isbn === null) {
            return $this->db->get('buku')->result_array();
        } else {
            return $this->db->get_where('buku', ['isbn' => $isbn])->result_array();
        }
    }

    public function deleteBuku($isbn)
    {
        $this->db->delete('buku', ['isbn' => $isbn]);
        return $this->db->affected_rows();
    }

    public function createBuku($data)
    {
        $this->db->insert('buku', $data);
        return $this->db->affected_rows();
    }

    public function updateBuku($data, $isbn)
    {
        $this->db->update('buku', $data, ['isbn' => $isbn]);
        return $this->db->affected_rows();
    }
}
