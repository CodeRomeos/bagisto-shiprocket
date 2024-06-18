<?php

namespace CodeRomeos\BagistoShiprocket\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Shiprocket
{

    protected $baseUrl;

    protected $userEmail;

    protected $userPassword;

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseUrl = config('shiprocket.baseUrl');
        $this->userEmail = config('shiprocket.userEmail');
        $this->userPassword = config('shiprocket.userPassword');

        $this->cacheToken();
    }


    public function generateToken()
    {
        $response = Http::post($this->baseUrl . '/auth/login', [
            'email' => $this->userEmail,
            'password' => $this->userPassword,
        ]);

        if ($response->failed()) {
            return false;
        }

        $json = $response->json();

        return isset($json['token']) ? $json['token'] : false;
    }

    function cacheToken()
    {
        $token = Cache::get('bagistoshiprocket_token');

        if ($token) return $token;

        if ($token = $this->generateToken()) {
            Cache::put('bagistoshiprocket_token', $token, 60 * 24 * 8);
            return $token;
        }

        return false;
    }

    public function trackAWB($awb)
    {
        $token = Cache::get('bagistoshiprocket_token');

        if (!$token) {
            return false;
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($this->baseUrl . '/courier/track/awb/' . $awb);
        if ($response->failed()) {
            return false;
        }

        $json = $response->json();
        return $json;
    }

    public function getEstimatedDelivery(Request $request)
    {
        $token = Cache::get('bagistoshiprocket_token');

        if (!$token) {
            return false;
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($this->baseUrl . '/courier/serviceability', $request->all());
        if ($response->failed()) {
            return false;
        }

        $json = $response->json();
        return $json;
    }
}
