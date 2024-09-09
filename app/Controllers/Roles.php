<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException; // Add this line
use App\Models\RoleModel;
use CodeIgniter\HTTP\Response;

class Roles extends BaseController
{
    public $roleModel;

    function __construct()
    {
        $this->roleModel = model(RoleModel::class);
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

        return view('templates/header', $data)
            . view("$class/$method")
            . view('templates/footer');
    }

    function datatable()
    {
        $i = 1;

        $params = $this->request->getGet(['offset', 'limit', 'search', 'sort', 'order']);

        $roles = $this->roleModel->getDatatable($params);

        $total = $this->roleModel->countFiltered($params);

        $records = [];
        foreach ($roles as $role) {
            $record = new \stdClass();
            $record->id = $role['id'];
            $record->name = $role['name'];
            $record->created_at = date("F jS, Y, g:i a", strtotime($role['created_at']));
            $record->sn = $params['offset'] + $i++;

            $records[] = $record;
        }

        $data['rows'] = $records;
        $data['total'] = $total;
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function form($id = null)
    {
        helper('form');


        $router = service('router');
        $class = basename(str_replace('\\', '/', $router->controllerName()));
        $method = $router->methodName();

        if (!is_file(APPPATH . "Views/{$class}/{$method}.php")) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($method);
        }

        $data['title'] = $id ? "Edit $class" : "Add $class";
        $data['role'] = $id ? $this->roleModel->find($id) : $this->roleModel->getNew();

        if ($this->request->isAJAX()) {
            return view("$class/$method", $data);
        }

        return view('templates/header',)
            . view("$class/$method", $data)
            . view('templates/footer');
    }

    function save()
    {
        $session = session();
        try {
            helper('form');

            $data = $this->request->getPost(['id', 'name']);

            //Checks whether the submitted data passed the validation rules.
            if (!$this->validateData($data, [
                'name' => 'required|max_length[50]|min_length[3]',
            ]))
            //if (true)
            {
                // Return an error response with HTTP status code 400

                return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST)
                    ->setContentType('application/json')
                    ->setJSON([
                        'success' => false,
                        'message' => validation_errors()
                    ]);
            }

            // Gets the validated data.
            $post = $this->validator->getValidated();

            $model = model(RoleModel::class);

            $model->save([
                'id' => $data['id'],
                'name' => $post['name'],
                'added_by' => 1,
                'modified_by' => 1,
            ]);


            $logData['action'] = $data['id'] ? "edit" : "add";
            $logData['name'] = "Role {$post['name']} was {$logData['action']}ed by {$session->get('userData')['fullName']}";

            \CodeIgniter\Events\Events::trigger('record_log', $logData);
            // Return a success response with HTTP status code 200
            return $this->response->setStatusCode(Response::HTTP_OK)
                ->setContentType('application/json')
                ->setJSON([
                    'success' => true,
                    'message' => 'Your success message here'
                ]);
        } catch (\Exception $ex) {
            // Return an error response with HTTP status code 400
            return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST)
                ->setContentType('application/json')
                ->setJSON([
                    'success' => false,
                    'message' => $ex->getMessage()
                ]);
        }
    }

    function delete()
    {
        $session = session();
        $this->roleModel = model(RoleModel::class);

        $id = $this->request->getPost('id');
        $role = $this->roleModel->find($id);
        if ($this->roleModel->delete($id)) {

            $logData['action'] = "delete";
            $logData['name'] = "Role {$role['name']} was {$logData['action']}ed by {$session->get('userData')['fullName']}";

            \CodeIgniter\Events\Events::trigger('record_log', $logData);

            return $this->response->setStatusCode(Response::HTTP_OK)
                ->setContentType('application/json')
                ->setJSON([
                    'success' => true,
                    'message' => 'Your success message here'
                ]);
        } else {
            // Return an error response with HTTP status code 400
            return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST)
                ->setContentType('application/json')
                ->setJSON([
                    'success' => false,
                    'message' => "operation failed"
                ]);
        }
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

        return view('templates/header', $data)
            . view("$class/$method")
            . view('templates/footer');
    }
}
