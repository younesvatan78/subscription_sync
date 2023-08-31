<?php

namespace App\Http\Controllers;

use App\Services\CheckSubStatusService;
use Illuminate\Http\JsonResponse;

class AdminNotifyExpiredController extends Controller
{
    public function index(CheckSubStatusService $subscriptionService): JsonResponse
    {
        $platform = request()->query('platform');

        $latestExpiredSubscriptions = $subscriptionService->GetLatestExpiredSubs($platform);
        return response()->json([
            'data' => $latestExpiredSubscriptions,
        ]);
    }
        
}
