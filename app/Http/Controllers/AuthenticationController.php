<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use App\Services\CredentialService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Exception;

class AuthenticationController extends Controller
{
    public ApiService $service;

    public function __construct(ApiService $apiService)
    {
        $this->service = $apiService;
    }

    /**
     * @throws GuzzleException
     */
    public function handleRedirect(Request $request)
    {
        $authorizationCode = $request->code;
        if (!$authorizationCode) return response(['message' => 'No authorization code'], 400);

        $tokens = $this->service->getTokensByCode($authorizationCode);
        (new CredentialService())->renewTokens($tokens);
        return response([
            'message' => 'Authorization success'
        ]);
    }

    public function getAccessToken(Request $request){
        if($request->key != env('ACCESS_KEY')){
            return response([
                'error' => 'Unauthorized request !'
            ],403);
        }
        try {
            return response([
                'access_token' => (new CredentialService())->getAccessToken()
            ]);
        }catch (Exception|GuzzleException $exception){
            return response([
                'error' => 'Access token not available !'
            ],400);
        }
    }
}
