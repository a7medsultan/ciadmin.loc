<?php

namespace App\Controllers\Base;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\NotificationModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\Response;

class Notifications extends BaseController
{
    public $notificationModel;
    public $module;
    public $class;
    public $template_header;
    public $template_footer;


    function __construct()
    {
        $this->notificationModel = model(NotificationModel::class);

        $router = service('router');
        $this->module = 'Base';
        $this->class = basename(str_replace('\\', '/', $router->controllerName()));
        $this->template_header = 'templates/header';
        $this->template_footer = 'templates/footer';
    }

    public function index()
    {
        $router = service('router');
        $method = $router->methodName();

        if (!is_file(APPPATH . "Views/{$this->module}/{$this->class}/{$method}.php")) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($method);
        }

        $data['title'] = ucfirst($method); // Capitalize the first letter
        $data['module'] = $this->module;
        $data['class'] = $this->class;

        if ($this->request->isAJAX()) {
            return view("{$this->module}/{$this->class}/{$method}");
        }

        return view($this->template_header, $data)
            . view("{$this->module}/{$this->class}/{$method}")
            . view($this->template_footer);
    }

    function datatable()
    {

        $i = 1;

        $params = $this->request->getGet(['offset', 'limit', 'search', 'sort', 'order']);

        $records = $this->notificationModel->getDatatable($params);

        $total = $this->notificationModel->countFiltered($params);

        $rows = [];
        foreach ($records as $record) {
            $row = new \stdClass();
            $row->id = $record['id'];
            $row->description = $record['description'];

            $cssClass = 'primary';

            if ($record['type'] == 'email') {
                $cssClass = 'info';
            }
            if ($record['type'] == 'sms') {
                $cssClass = 'secondary';
            }


            $row->type = "<span class='badge p-2 bg-{$cssClass}'>{$record['type']}</span>";
            $row->created_at = date("F jS, Y, g:i a", strtotime($record['created_at']));
            $row->sentIcon = $record['sent'] ? '<i class=" text-success fas fa-check-double"></i>' : '<i class="text-secondary fas fa-hourglass-half"></i>';
            $row->sn = $params['offset'] + $i++;

            $rows[] = $row;
        }

        $data['rows'] = $rows;
        $data['total'] = $total;
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
