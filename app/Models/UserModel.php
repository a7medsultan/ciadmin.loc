<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'first_name',
        'last_name',
        'full_name',
        'email',
        'phone',
        'password',
        'role_id',
        'created_at',
        'updated_at',
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
        $record['first_name'] = '';
        $record['last_name'] = '';
        $record['email'] = '';
        $record['phone'] = '';
        $record['password'] = '';
        $record['role_id'] = '';
        $record['department_id'] = '';

        return $record;
    }

    function getName($id)
    {
        $record = $this->select('full_name')->where('id', $id)->get()->getRow(); // Fetch the row corresponding to the given ID
        if ($record) {
            return $record->name; // Return the name if a row is found
        } else {
            return false; // Return false if no row is found
        }
    }

    public function getDatatable($params = null)
    {
        $where = "";
        if ($params['search']) {
            $where = "phone like '%{$params['search']}%' or LOWER(full_name) like '%{$params['search']}%' or LOWER(email) like '%{$params['search']}%'";
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
            $where = "phone like '%{$params['search']}%' or LOWER(full_name) like '%{$params['search']}%' or LOWER(email) like '%{$params['search']}%' or created_at like '%{$params['search']}%' or created_at like '%{$params['search']}%'";
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
