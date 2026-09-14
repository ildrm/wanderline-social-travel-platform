<?php

namespace App\Support\Http;

use App\Domain\Journeys\Exceptions\DraftItineraryConflict;
use App\Domain\Journeys\Exceptions\InvalidJourneyTransition;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class ProblemDetailsResponse
{
    /** @param array{database: string, redis: string, storage: string} $checks */
    public static function readinessFailure(Request $request, array $checks): JsonResponse
    {
        $correlationId = self::correlationId($request);

        return response()->json([
            'type' => 'urn:problem:journeys:service-unavailable',
            'title' => 'Service unavailable',
            'status' => Response::HTTP_SERVICE_UNAVAILABLE,
            'detail' => 'One or more required services are unavailable.',
            'instance' => '/'.$request->path(),
            'correlation_id' => $correlationId,
            'checks' => $checks,
        ], Response::HTTP_SERVICE_UNAVAILABLE, [
            'Content-Type' => 'application/problem+json',
            'X-Correlation-ID' => $correlationId,
        ], JSON_UNESCAPED_SLASHES);
    }

    public static function fromThrowable(Throwable $exception, Request $request): JsonResponse
    {
        $correlationId = self::correlationId($request);
        [$status, $slug, $title, $detail] = self::describe($exception);

        $problem = [
            'type' => "urn:problem:journeys:{$slug}",
            'title' => $title,
            'status' => $status,
            'detail' => $detail,
            'instance' => '/'.$request->path(),
            'correlation_id' => $correlationId,
        ];

        if ($exception instanceof ValidationException) {
            $problem['errors'] = $exception->errors();
        }

        $headers = [
            ...($exception instanceof HttpExceptionInterface ? $exception->getHeaders() : []),
            'Content-Type' => 'application/problem+json',
            'X-Correlation-ID' => $correlationId,
        ];

        if ($status === Response::HTTP_UNAUTHORIZED) {
            $headers['WWW-Authenticate'] = 'Bearer';
        }

        return response()->json($problem, $status, $headers, JSON_UNESCAPED_SLASHES);
    }

    private static function correlationId(Request $request): string
    {
        $correlationId = $request->attributes->get('correlation_id');

        if (is_string($correlationId) && $correlationId !== '') {
            return $correlationId;
        }

        $correlationId = (string) Str::uuid();
        $request->attributes->set('correlation_id', $correlationId);

        return $correlationId;
    }

    /** @return array{int, string, string, string} */
    private static function describe(Throwable $exception): array
    {
        return match (true) {
            $exception instanceof ValidationException => [422, 'validation-error', 'Validation failed', 'One or more fields are invalid.'],
            $exception instanceof AuthenticationException => [401, 'unauthenticated', 'Authentication required', 'Valid authentication credentials are required.'],
            $exception instanceof AuthorizationException => [403, 'forbidden', 'Access denied', 'You are not authorized to perform this action.'],
            $exception instanceof ModelNotFoundException => [404, 'not-found', 'Resource not found', 'The requested resource was not found.'],
            $exception instanceof InvalidJourneyTransition => [409, 'invalid-journey-transition', 'Journey transition rejected', $exception->getMessage()],
            $exception instanceof DraftItineraryConflict => [409, 'draft-itinerary-conflict', 'Itinerary rejected', $exception->getMessage()],
            $exception instanceof AccessDeniedHttpException => [403, 'forbidden', 'Access denied', 'You are not authorized to perform this action.'],
            $exception instanceof HttpExceptionInterface => self::describeHttpException($exception),
            default => [500, 'internal-error', 'Internal server error', 'An unexpected error occurred.'],
        };
    }

    /** @return array{int, string, string, string} */
    private static function describeHttpException(HttpExceptionInterface $exception): array
    {
        $status = $exception->getStatusCode();
        $title = Response::$statusTexts[$status] ?? 'Request failed';

        return [$status, Str::kebab($title), $title, $title.'.'];
    }
}
