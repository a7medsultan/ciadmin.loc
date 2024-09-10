<?php

namespace App\Models;

use CodeIgniter\Model;

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{

    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'description',
        'type',
        'receivers',
        'viewed_by',
        'sent',
        'added_by',
        'modified_by'
    ];
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
        $record['description'] = '';
        $record['type'] = '';
        $record['sent'] = 0;

        return $record;
    }

    public function getDatatable($params = null)
    {
        $where = "";
        if ($params['search']) {
            $where = "description like '%{$params['search']}%' or created_at like '%{$params['search']}%' or type like '%{$params['search']}%'";
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
            $where = "description like '%{$params['search']}%' or created_at like '%{$params['search']}%' or type like '%{$params['search']}%'";
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
