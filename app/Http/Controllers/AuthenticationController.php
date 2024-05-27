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
            $token = (new CredentialService())->getAccessToken();
            return response([
                'access_token' => $token['token'],
                'valid_till' => $token['valid_till']
            ]);
        }catch (Exception|GuzzleException $exception){
            return response([
                'error' => 'Access token not available !'
            ],400);
        }
    }

    public function removeTokens(Request $request){
        if($request->key != env('ACCESS_KEY')){
            return response([
                'error' => 'Unauthorized request !'
            ],403);
        }

        (new CredentialService())->removeTokens();
        return response([
            'message' => "Tokens has been removed"
        ]);
    }
}
