<?php

namespace App\Http\Controllers\Shared;

use Illuminate\Http\Response;

class ApiController extends Controller
{
    protected $statusCode = Response::HTTP_OK;

    public function status($statusCode = Response::HTTP_OK)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respond($response)
    {
        return response()->json($response, $this->statusCode, [], JSON_UNESCAPED_SLASHES);
    }

    public function respondOk($data = [], $message = 'Data found.')
    {
        return $this
            ->status(Response::HTTP_OK)
            ->respond([
                'status' => true,
                'message' => $message,
                'data' => $data,
            ]);
    }

    public function respondNotFound($message = "Data not found.")
    {
        return $this
            ->status(Response::HTTP_NOT_FOUND)
            ->respond([
                'status' => false,
                'message' => $message,
                'data' => [],
            ]);
    }

    public function respondUnauthorized($errors = [], $message = "Unauthorized.")
    {
        return $this
            ->status(Response::HTTP_UNAUTHORIZED)
            ->respond([
                "status" => false,
                'data' => [
                    'errors' => $errors
                ],
                'message' => $message,
            ]);
    }

    public function respondForbidden($errors = [], $message = "Forbidden.")
    {
        return $this
            ->status(Response::HTTP_FORBIDDEN)
            ->respond([
                'status' => false,
                'data' => [
                    'errors' => $errors
                ],
                'message' => $message,
            ]);
    }

    public function respondValidationFailed($errors = [], $message = "Invalid data.")
    {
        return $this
            ->status(Response::HTTP_BAD_REQUEST)
            ->respond([
                'status' => false,
                'message' => $message,
                'data' => [
                    'errors' => $errors
                ]
            ]);
    }

    public function respondBadRequest($message = "Bad request.")
    {
        return $this
            ->status(Response::HTTP_BAD_REQUEST)
            ->respond([
                'status' => false,
                'message' => $message,
            ]);
    }

    public function respondInternalServerError($message = 'Something went wrong and we are on it.')
    {
        return $this
            ->status(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->respond([
                'status' => false,
                'message' => $message,
            ]);
    }

    public function respondCreated($data = [], $message = 'Data created.')
    {
        return $this
            ->status(Response::HTTP_CREATED)
            ->respond([
                'status' => true,
                'message' => $message,
                'data' => $data,
            ]);
    }
}