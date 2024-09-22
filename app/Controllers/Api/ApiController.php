<?php

namespace App\Controllers\Api;

use App\Models\FacilityModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ApiController extends ResourceController
{
    function findFacility()
    {
        $facilityModel = model(FacilityModel::class);
        // search param
        $rules = [
            "search" => "required",
            "limit" => "required|numeric",
            "offset" => "required|numeric"
        ];

        // Validate input
        if (!$this->validate($rules)) {
            $response = [
                "status" => false,
                "message" => $this->validator->getErrors(), // Return validation errors
                "data" => []
            ];
        } else {
            // Get search and pagination parameters
            $search = $this->request->getVar('search');
            $limit = $this->request->getVar('limit', FILTER_VALIDATE_INT) ?? 10; // Default limit if not provided
            $offset = $this->request->getVar('offset', FILTER_VALIDATE_INT) ?? 0; // Default offset if not provided

            // Initialize the query
            $facilityModel = new FacilityModel();

            if ($search) {
                // Use query bindings to prevent SQL injection
                $facilityModel->like('name', $search);
            }

            // Fetch facilities with pagination
            $facilities = $facilityModel->findAll($limit, $offset);

            // Prepare the response
            $response = [
                "status" => true,
                "message" => count($facilities) ? "Found some facilities" : "No facilities found",
                "data" => $facilities
            ];
        }

        // Return the response with the correct status code
        return $this->response->setJSON($response)->setStatusCode(200);
    }
}
