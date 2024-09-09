<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\SettingModel;
use CodeIgniter\HTTP\Response;

class Settings extends BaseController
{

    public $settingsModel;

    function __construct()
    {
        $this->settingsModel = model(SettingModel::class);
    }

    public function index()
    {
        helper('form');
        $router = service('router');

        $class = basename(str_replace('\\', '/', $router->controllerName()));
        $method = $router->methodName();

        if (!is_file(APPPATH . "Views/{$class}/{$method}.php")) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($method);
        }

        $data['title'] = ucfirst($method); // Capitalize the first letter

        $settings = $this->settingsModel->find(1);

        if (!$settings) {
            $general_settings = [
                'default_language' => 'en',
                'email_notifications' => 'on'
            ];
            $email_settings = [
                'email' => 'email@email.com',
                'password' => 'mypassword',
                'encryption' => 'none'
            ];
            $sms_settings = [
                'url' => 'http://someapi.com/api/',
                'api_key' => '83208749274921032hdkf93',
            ];
            $system_settings = [
                'general_settings' => $general_settings,
                'email_settings' => $email_settings,
                'sms_settings' => $sms_settings,
            ];

            //pr($system_settings);
            $this->settingsModel->insert([
                'system_settings' => json_encode($system_settings)
            ]);
        }

        $data['settings'] = json_decode($settings['system_settings'], true);
        if ($this->request->isAJAX()) {
            return view("$class/$method");
        }

        return view('templates/header', $data)
            . view("$class/$method")
            . view('templates/footer');
    }

    function save()
    {
        try {
            helper('form');

            $data = $this->request->getPost([
                'default_language',
                'email_notifications',
                'full_screen',
                'mail_server',
                'port_number',
                'encryption',
                'email',
                'password',
                'api_url',
                'api_key'
            ]);

            //Checks whether the submitted data passed the validation rules.
            if (!$this->validateData($data, [
                'default_language' => 'required',
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

            $general_settings = [
                'default_language' => $post['default_language'],
                'email_notifications' => $data['email_notifications'],
                'full_screen' => $data['full_screen'],
            ];
            $email_settings = [
                'mail_server' => $data['mail_server'],
                'port_number' => $data['port_number'],
                'encryption' => $data['encryption'],
                'email' => $data['email'],
                'password' => $data['password'],
            ];
            $sms_settings = [
                'api_url' => $data['api_url'],
                'api_key' => $data['api_key'],
            ];
            $system_settings = [
                'general_settings' => $general_settings,
                'email_settings' => $email_settings,
                'sms_settings' => $sms_settings,
            ];

            $this->settingsModel->save([
                'id' => 1,
                'system_settings' => json_encode($system_settings)
            ]);

            // Return a success response with HTTP status code 200
            return $this->response->setStatusCode(Response::HTTP_OK)
                ->setContentType('application/json')
                ->setJSON([
                    'success' => true,
                    'message' => 'The record is saved successfully'
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
}