<?php
namespace App\Models;

use Core\DB;

class BaseModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function getById($id)
    {
        $params = [
            'id' => $id
        ];

        return ($article = $this->db->select($this->table, $params, DB::FETCH_ONE)) ? $article : false;
    }

    public function delete($id)
    {
        $params = [
            'id' => $id
        ];

        return ($this->db->delete($this->table, $params)) ? true : false;
    }

}
