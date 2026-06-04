<?php

namespace App\Http\Traits;

trait ApiResponse
{
    protected function success($data = null, string $message = 'Berhasil', int $code = 200)
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    protected function created($data = null, string $message = 'Data berhasil dibuat')
    {
        return $this->success($data, $message, 201);
    }

    protected function error(string $message = 'Terjadi kesalahan', int $code = 400, $errors = null)
    {
        $response = [
            'status'  => false,
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    protected function notFound(string $message = 'Data tidak ditemukan')
    {
        return $this->error($message, 404);
    }

    protected function serverError(string $message = 'Terjadi kesalahan pada server', $error = null)
    {
        $response = [
            'status'  => false,
            'message' => $message,
        ];

        if (config('app.debug') && $error) {
            $response['error'] = $error;
        }

        return response()->json($response, 500);
    }
}
