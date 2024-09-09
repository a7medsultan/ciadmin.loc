<?php

namespace App\Models;

use CodeIgniter\Model;

namespace App\Models;

use CodeIgniter\Model;

class SystemLogModel extends Model
{

    protected $table = 'system_log';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['action', 'name'];
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
        $record['name'] = '';

        return $record;
    }

    public function getDatatable($params = null)
    {
        $where = "";
        if ($params['search'])
        {
            $where = "name like '%{$params['search']}%' or created_at like '%{$params['search']}%' or action like '%{$params['search']}%'";
            $this->where($where);
        }

        if ($params['sort'])
        {
            $this->orderBy($params['sort'], $params['order']);
        } else
        {
            $this->orderBy('id', 'desc');
        }

        $users = $this->findAll($params['limit'], $params['offset']);

        return $users;
    }

    public function countFiltered($params = null)
    {
        $where = "";
        if ($params['search'])
        {
            $where = "name like '%{$params['search']}%' or created_at like '%{$params['search']}%' or action like '%{$params['search']}%'";
            $this->where($where);
        }

        if ($params['sort'])
        {
            $this->orderBy($params['sort'], $params['order']);
        } else
        {
            $this->orderBy('id', 'desc');
        }
        $total = $this->countAllResults();

        return $total;
    }
}
