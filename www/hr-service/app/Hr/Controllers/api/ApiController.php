<?php

namespace App\Hr\Controllers\api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as IlluminateResponse;

abstract class ApiController extends Controller
{
    private $statusCode = IlluminateResponse::HTTP_OK;

    protected function getStatusCode(): int
    {
        return $this->statusCode;
    }

    protected function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    protected function respondNotFound(string $message = 'Not Found!'): JsonResponse
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }

    protected function respondBadRequest(string $message = 'Bad Request!'): JsonResponse
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_BAD_REQUEST)->respondWithError($message);
    }

    protected function respondInternalError(string $message = 'Internal Error!'): JsonResponse
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    protected function respondValidationError(string $message = 'Validation Error!'): JsonResponse
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)->respondWithError($message);
    }

    protected function respondForbidden(string $message = 'Forbidden!'): JsonResponse
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_FORBIDDEN)->respondWithError($message);
    }

    protected function respondUnavailabilityError(string $message = 'Resource Exists No More!'): JsonResponse
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_GONE)->respondWithError($message);
    }

    /**
     * Respond Json.
     *
     * @param  array or object $data
     * @param  array  $headers
     * @return JsonResponse
     */
    protected function respond($data, array $headers = []): JsonResponse
    {
        return response()->json(
            [
                'data' => $data,
            ],
            $this->getStatusCode(),
            $headers,
        );
    }

    /**
     * Get's a pagination collection directly or via resource and responds custom JSON.
     *
     * @param  mixed collection
     * @param  array  $headers
     * @return JsonResponse
     */
    protected function respondPaginated($paginatedCollection, array $headers = []): JsonResponse
    {
        if (!is_object($paginatedCollection)) {
            return $this->respond($paginatedCollection);
        }

        $className = get_class($paginatedCollection);

        if (!in_array($className, $this->getAllowedPaginationClassNames())) {
            throw new Exception('Unsupported pagination class.');
        }

        $response = [
            'data' => $paginatedCollection->items(),
            'current_page' => $paginatedCollection->currentPage(),
        ];

        if ($className !== 'Illuminate\Pagination\Paginator') {
            $response['last_page'] = $paginatedCollection->lastPage();
            $response['total'] = $paginatedCollection->total();
        }

        return response()->json(
            $response,
            $this->getStatusCode(),
            $headers,
        );
    }

    protected function respondSuccess($message, $data, $headers = []): JsonResponse
    {
        return response()->json(
            [
                'message' => $message,
                'data' => $data,
            ],
            IlluminateResponse::HTTP_OK,
            $headers,
        );
    }

    protected function respondWithError($message): JsonResponse
    {
        return response()->json(
            [
                'error' => [
                    'message' => $message,
                    'status_code' => $this->getStatusCode(),
                ],
            ],
            $this->getStatusCode(),
        );
    }

    protected function respondCreated(string $message, $data = null, $headers = []): JsonResponse
    {
        return response()->json(
            [
                'message' => $message,
                'data' => $data,
            ],
            IlluminateResponse::HTTP_CREATED,
            $headers,
        );
    }

    private function getAllowedPaginationClassNames(): array
    {
        return [
            'Illuminate\Pagination\LengthAwarePaginator',
            'Illuminate\Pagination\Paginator',
            'Illuminate\Http\Resources\Json\AnonymousResourceCollection',
        ];
    }
}
