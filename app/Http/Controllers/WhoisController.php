<?php

namespace App\Http\Controllers;

use App\Http\Requests\WhoisRequest;
use App\Services\WhoisService;
use Exception;
use Illuminate\Http\JsonResponse;

class WhoisController extends Controller
{
    protected WhoisService $whoisService;

    public function __construct(WhoisService $whoisService)
    {
        $this->whoisService = $whoisService;
    }

    public function getWhoisInfo(WhoisRequest $request): JsonResponse
    {
        $domain = strtolower(trim($request->input('domain')));

        try {
            $whoisData = $this->whoisService->getWhoisData($domain);

            return response()->json([
                'success' => true,
                'domain' => $domain,
                'whois_data' => $whoisData
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'domain' => $domain,
                'error' => 'Failed to retrieve WHOIS information',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
