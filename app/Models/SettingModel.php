<?php

namespace App\Models;

use CodeIgniter\Model;

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{

    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['system_settings'];
    protected bool $allowEmptyInserts = false;
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted';

    public function getNew()
    {
        $record['id'] = '';
        $record['name_en'] = '';
        $record['name_ar'] = '';

        return $record;
    }

    function getNameEn($id)
    {
        $record = $this->select('name_en')->where('id', $id)->get()->getRow(); // Fetch the row corresponding to the given ID
        if ($record) {
            return $record->name_en; // Return the name_en if a row is found
        } else {
            return false; // Return false if no row is found
        }
    }

    function getNameAr($id)
    {
        $record = $this->select('name_ar')->where('id', $id)->get()->getRow(); // Fetch the row corresponding to the given ID
        if ($record) {
            return $record->name_ar; // Return the name_ar if a row is found
        } else {
            return false; // Return false if no row is found
        }
    }

    public function getDatatable($params = null)
    {
        $where = "";
        if ($params['search']) {
            $where = "name_en like '%{$params['search']}%' or name_ar like '%{$params['search']}%' or created_at like '%{$params['search']}%'";
            $this->where($where);
        }

        if ($params['sort']) {
            $this->orderBy($params['sort'], $params['order']);
        } else {
            $this->orderBy('id', 'desc');
        }

        $users = $this->findAll($params['limit'], $params['offset']);

        return $users;
    }

    public function countFiltered($params = null)
    {
        $where = "";
        if ($params['search']) {
            $where = "name_en like '%{$params['search']}%' or name_ar like '%{$params['search']}%' or created_at like '%{$params['search']}%'";
            $this->where($where);
        }

        if ($params['sort']) {
            $this->orderBy($params['sort'], $params['order']);
        } else {
            $this->orderBy('id', 'desc');
        }
        $total = $this->countAllResults();

        return $total;
    }
}
