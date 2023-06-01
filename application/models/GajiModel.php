<?php
class GajiModel extends CI_Model
{
    public function getData($table)
    {
        return $this->db->get($table);
    }
    public function insertData($table, $data)
    {
        $this->db->insert($table, $data);
    }
    public function updateData($table, $data, $where)
    {
        $this->db->update($table, $data, $where);
    }
    public function deleteData($table, $where)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
    public function jmlData($kolom,$cari,$table){
        $this->db->like($kolom,$cari); // WHERE `kolom` LIKE '%match%' ESCAPE '!'
        $this->db->from($table);
        return $this->db->count_all_results();

    }
    public function cariData($kolom,$cari,$table)
    {
        $this->db->where($kolom,$cari);
        return $this->db->get($table);
    }
}
