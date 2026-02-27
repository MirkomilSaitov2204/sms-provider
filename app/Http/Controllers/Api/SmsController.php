<?php

namespace App\Http\Controllers\Api;

use App\Application\DTO\SendSmsRequestDto;
use App\Application\DTO\SmsHistoryFilterDto;
use App\Domain\Contracts\SmsServiceInterface;
use App\Domain\Exceptions\InvalidApiKeyException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SendSmsRequest;
use App\Http\Requests\Api\SmsHistoryRequest;
use App\Http\Resources\SendSmsResultResource;
use App\Http\Resources\SmsMessageResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

class SmsController extends Controller
{
    public function send(SendSmsRequest $request, SmsServiceInterface $smsService): JsonResponse
    {
        try {
            $result = $smsService->send(
                SendSmsRequestDto::fromArray($request->validated())
            );

            return ApiResponse::success(new SendSmsResultResource($result));
        } catch (InvalidApiKeyException $exception) {
            return ApiResponse::error($exception->getMessage(), 401);
        }
    }

    public function history(SmsHistoryRequest $request, SmsServiceInterface $smsService): JsonResponse
    {
        try {
            $paginator = $smsService->history(
                SmsHistoryFilterDto::fromArray($request->validated())
            );

            return ApiResponse::success(
                SmsMessageResource::collection($paginator->items()),
                [
                    'current_page' => $paginator->currentPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                    'last_page' => $paginator->lastPage(),
                ]
            );
        } catch (InvalidApiKeyException $exception) {
            return ApiResponse::error($exception->getMessage(), 401);
        }
    }
}
