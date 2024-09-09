<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\RoleModel;
use App\Models\UserModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\Response;

class Users extends BaseController
{

    public $userModel;
    public $roleModel;

    function __construct()
    {
        $this->userModel = model(UserModel::class);
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

        $users = $this->userModel->getDatatable($params);

        $total = $this->userModel->countFiltered($params);

        $records = [];
        foreach ($users as $user) {
            $record = new \stdClass();
            $record->id = $user['id'];
            $record->full_name = $user['full_name'];
            $record->email = $user['email'];
            $record->phone = $user['phone'];
            $record->role = $this->roleModel->find($user['role_id'])['name'];
            $record->created_at = date("F jS, Y, g:i a", strtotime($user['created_at']));
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

        $data['roles'] = $this->roleModel->findAll();
        $data['title'] = $id ? "Edit $class" : "Add $class";
        $data['user'] = $id ? $this->userModel->find($id) : $this->userModel->getNew();

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

            $data = $this->request->getPost(['id', 'first_name', 'last_name', 'email', 'phone', 'password', 'password_confirmation', 'role_id']);

            //Checks whether the submitted data passed the validation rules.
            $validation = Services::validation();


            // Define base validation rules
            $validationRules = [
                'first_name' => 'required|max_length[50]|min_length[3]',
                'last_name' => 'required|max_length[50]|min_length[3]',
                'email' => "required|max_length[254]|valid_email|is_unique[users.email,id,{$data['id']}]",
                'phone' => 'required|max_length[16]|min_length[9]',
                'role_id' => 'required',
            ];

            // Modify password validation rule based on condition
            if ($data['password']) {
                $validationRules['password'] = [
                    'label' => 'Password',
                    'rules' => $data['id'] ? 'required|min_length[8]|max_length[255]|regex_match[^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$]' : 'min_length[8]|max_length[255]|regex_match[^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$]',
                    'errors' => [
                        'regex_match' => 'Password must be at least 8 characters long and include one uppercase letter, one lowercase letter, one number, and one special character.'
                    ]
                ];
                $validationRules['password_confirmation'] = 'required|matches[password]';
            }

            if (!$this->validateData($data, $validationRules))
            //if (true)
            {
                // Return an error response with HTTP status code 400

                return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST)
                    ->setContentType('application/json')
                    ->setJSON([
                        'success' => false,
                        'message' => $validation->getErrors()
                    ]);
            }

            // Gets the validated data.
            $post = $this->validator->getValidated();

            if ($data['id']) {
                // Fetch the existing user record
                $user = $this->userModel->find($data['id']);

                if ($user) {
                    // Assign the user model for updating
                    $model = $this->userModel;
                } else {
                    // Handle case where user is not found, if needed
                    throw new PageNotFoundException();
                }
            } else {
                // Create a new instance for a new user
                $model = model(UserModel::class);
            }

            // Use the model object to save the data
            $model->save([
                'id' => $data['id'] ?? null, // null for new users
                'first_name' => $post['first_name'],
                'last_name' => $post['last_name'],
                'full_name' => "{$post['first_name']} {$post['last_name']}",
                'email' => $post['email'],
                'phone' => str_replace(['(', ')', '-', ' '], '', $post['phone']),
                'password' => $data['password'] ? password_hash($post['password'], PASSWORD_DEFAULT) : $user['password'] ?? null, // Use the existing password if it's an update
                'role_id' => $post['role_id'],
                'added_by' => 1,
                'modified_by' => 1,
            ]);

            // log insert/save

            $logData['action'] = $data['id'] ? "edit" : "add";
            $logData['name'] = "User {$post['first_name']} {$post['last_name']} was {$logData['action']}ed by {$session->get('userData')['fullName']}";

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
        $this->userModel = model(UserModel::class);

        $id = $this->request->getPost('id');
        $user = $this->userModel->find($id);
        if ($this->userModel->delete($id)) {

            $logData['action'] = "delete";
            $logData['name'] = "User {$user['full_name']} was {$logData['action']}ed by {$session->get('userData')['fullName']}";

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

        if ($this->request->isAJAX()) {
            return view("$class/$method");
        }

        return view('templates/header', $data)
            . view("$class/$method")
            . view('templates/footer');
    }

    function login()
    {
        if (session()->has('logged_in')) {
            return redirect()->to('dashboard/index');
        }

        helper('form');

        $router = service('router');
        $class = basename(str_replace('\\', '/', $router->controllerName()));
        $method = $router->methodName();

        if (!is_file(APPPATH . "Views/{$class}/{$method}.php")) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($method);
        }

        $data['title'] = lang('main.login');

        return view("$class/$method", $data);
    }

    function authenticate()
    {
        try {
            helper('form');
            $data = $this->request->getPost(['email', 'password']);

            //Checks whether the submitted data passed the validation rules.
            if (!$this->validateData($data, [
                'email' => [
                    'rules' => "required|max_length[100]|valid_email|is_not_unique[users.email]",
                    'errors' => [
                        'required' => 'The email is required',
                        'max_length' => 'Too long email',
                        'valid_email' => 'Enter a valid email',
                        'is_not_unique' => 'Email does not exists',
                    ]
                ],
                'password' => [
                    'rules' => 'required|max_length[20]|min_length[8]',
                    'errors' => [
                        'required' => 'The password is required',
                        'max_length' => 'Password must be < 20 character',
                        'min_length' => 'Password must be at least 8 characters long',
                    ]
                ],
            ]))
            //if (true)
            {
                // Return an error response with HTTP status code 400

                return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST)
                    ->setContentType('application/json')
                    ->setJSON([
                        'success' => false,
                        'message' => validation_list_errors()
                    ]);
            }

            // Gets the validated data.
            $post = $this->validator->getValidated();

            $model = model(UserModel::class);
            $password = password_hash($post['password'], PASSWORD_DEFAULT);
            $user = $this->userModel->where("email = '{$post['email']}'")->first();

            if (!$user || !password_verify($post['password'], $user['password'])) {
                // Return an error response with HTTP status code 400
                return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST)
                    ->setContentType('application/json')
                    ->setJSON([
                        'success' => false,
                        'message' => 'Email and Password combination is incorrect' . $password
                    ]);
            }

            // set session data
            $this->setSessionData($user);

            // Return a success response with HTTP status code 200
            return $this->response->setStatusCode(Response::HTTP_OK)
                ->setContentType('application/json')
                ->setJSON([
                    'success' => true,
                    'message' => lang('main.loggedIn')
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

    public function setSessionData($user)
    {
        // set auth data
        $session = session();
        $sessionData['id'] = $user['id'];
        $sessionData['fullName'] = $user['full_name'];
        $sessionData['superAdmin'] = $user['superadmin'];
        $sessionData['roleId'] = $user['role_id'];
        $sessionData['email'] = $user['email'];
        $sessionData['profileImage'] = $user['profile_image'];
        $sessionData['defaultLanguage'] = 'en';

        // check by $session->has() and $session->has()[id]
        $session->set('userData', $sessionData);
        $session->set('logged_in', true);
    }

    function logout()
    {
        $session = session();
        $session->remove('logged_in');
        $session->remove('userData');

        if ($session->has('logged_in')) {
            echo 'logged in';
        } else {
            echo 'logged out';
        }

        return redirect()->to('users/login');
    }

    function test()
    {
        $session = session();
        echo "by {$session->get('userData')['fullName']}";
    }
}
