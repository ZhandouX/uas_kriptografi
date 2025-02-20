<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;

class VerifyRecaptcha
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->input('g-recaptcha-response');

        if (!$token) {
            return back()->withErrors(['captcha' => 'Captcha wajib diisi']);
        }

        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $token,
            ],
        ]);

        $body = json_decode($response->getBody());

        if (!$body->success || $body->score < 0.5) {
            return back()->withErrors(['captcha' => 'Verifikasi captcha gagal']);
        }

        return $next($request);
    }
}
