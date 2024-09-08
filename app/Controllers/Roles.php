<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException; // Add this line
use App\Models\RoleModel;
class Roles extends BaseController
{

    public function index()
    {
        $router = service('router');
        $controller = explode(DIRECTORY_SEPARATOR, $router->controllerName());
        $class = $controller[count($controller) - 1];
        $method = $router->methodName();

        if (!is_file(APPPATH . "Views/{$class}/{$method}.php"))
        {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($method);
        }

        $data['title'] = ucfirst($method); // Capitalize the first letter

        return view('templates/header', $data)
                . view("$class/$method")
                . view('templates/footer');
    }

    function datatable()
    {
        $model = model(RoleModel::class);

        $roles = $model->get();
        
        
        $data['rows'] = $roles;
        $data['count'] = count($roles);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function save($id)
    {
        $router = service('router');
        $controller = explode(DIRECTORY_SEPARATOR, $router->controllerName());
        $class = $controller[count($controller) - 1];
        $method = $router->methodName();

        if (!is_file(APPPATH . "Views/{$class}/{$method}.php"))
        {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($method);
        }

        $data['title'] = ucfirst($method); // Capitalize the first letter

        return view('templates/header', $data)
                . view("$class/$method")
                . view('templates/footer');
    }

    public function view()
    {
        $router = service('router');
        $controller = explode(DIRECTORY_SEPARATOR, $router->controllerName());
        $class = $controller[count($controller) - 1];
        $method = $router->methodName();

        if (!is_file(APPPATH . "Views/{$class}/{$method}.php"))
        {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($method);
        }

        $data['title'] = ucfirst($method); // Capitalize the first letter

        return view('templates/header', $data)
                . view("$class/$method")
                . view('templates/footer');
    }
}
