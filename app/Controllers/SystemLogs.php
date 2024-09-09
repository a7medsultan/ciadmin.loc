<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\SystemLogModel;
use CodeIgniter\HTTP\Response;

class SystemLogs extends BaseController
{

    public $systemLogModel;

    function __construct()
    {
        $this->systemLogModel = model(SystemLogModel::class);
    }

    public function index()
    {
        $router = service('router');
        $class = basename(str_replace('\\', '/', $router->controllerName()));
        $method = $router->methodName();

        if (!is_file(APPPATH . "Views/{$class}/{$method}.php")) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($method);
        }

        $data['title'] = ucfirst($method); // Capitalize the first letter

        if ($this->request->isAJAX()) {
            return view("$class/$method");
        }

        return view('templates/header', $data)
            . view("$class/$method")
            . view('templates/footer');
    }

    function datatable()
    {
        $i = 1;

        $params = $this->request->getGet(['offset', 'limit', 'search', 'sort', 'order']);

        $records = $this->systemLogModel->getDatatable($params);

        $total = $this->systemLogModel->countFiltered($params);

        $rows = [];
        foreach ($records as $record) {
            $row = new \stdClass();
            $row->id = $record['id'];
            $row->name = $record['name'];

            $cssClass = 'warning';
            if ($record['action'] == 'add') {
                $cssClass = 'success';
            }
            if ($record['action'] == 'edit') {
                $cssClass = 'info';
            }
            if ($record['action'] == 'delete') {
                $cssClass = 'danger';
            }


            $row->action = "<span class='badge p-2 bg-{$cssClass}'>{$record['action']}</span>";
            $row->created_at = date("F jS, Y, g:i a", strtotime($record['created_at']));
            $row->sn = $params['offset'] + $i++;

            $rows[] = $row;
        }

        $data['rows'] = $rows;
        $data['total'] = $total;
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function view()
    {
        $router = service('router');

        $class = basename(str_replace('\\', '/', $router->controllerName()));
        $method = $router->methodName();

        if (!is_file(APPPATH . "Views/{$class}/{$method}.php")) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($method);
        }

        $data['title'] = ucfirst($method); // Capitalize the first letter

        if ($this->request->isAJAX()) {
            return view("$class/$method");
        }

        return view('templates/header', $data)
            . view("$class/$method")
            . view('templates/footer');
    }
}
