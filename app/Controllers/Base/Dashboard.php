<?php

namespace App\Controllers\Base;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException; // Add this line
use App\Models\RoleModel;

class Dashboard extends BaseController
{
    public $module;
    public $class;
    public $template_header;
    public $template_footer;

    function __construct()
    {
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

        //die($method);
        return view($this->template_header, $data)
            . view("{$this->module}/{$this->class}/{$method}")
            . view($this->template_footer);
    }

    function datatable()
    {
        $model = model(RoleModel::class);

        $roles = $model->get();

        print_r($roles);
        $data['rows'] = $roles;
        $data['count'] = count($roles);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
