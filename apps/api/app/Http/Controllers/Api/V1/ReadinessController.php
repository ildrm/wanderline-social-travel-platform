<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Support\Health\CheckReadiness;
use App\Support\Http\ProblemDetailsResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReadinessController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, CheckReadiness $readiness): JsonResponse
    {
        $checks = $readiness->handle();

        if (in_array('down', $checks, true)) {
            return ProblemDetailsResponse::readinessFailure($request, $checks);
        }

        return response()->json([
            'data' => [
                'status' => 'ready',
                'checks' => $checks,
            ],
        ], Response::HTTP_OK);
    }
}
