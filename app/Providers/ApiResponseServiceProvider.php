<?php

namespace App\Providers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('api', function ($data = null, $msg = '', $code = 200) {
            $res = [];
            $msg_lang = "messages.$msg";
            $res['message'] = Lang::has($msg_lang) ? __($msg_lang) : $msg;
            $res['status'] = $code;

            // if $data of type pagination
            if ($data instanceof LengthAwarePaginator) {
                $res['data'] = $data->items();

                $res['pagination'] = [
                    'current_page' => $data->currentPage(),
                    // 'data' => $data->items->toArray(),
                    'first_page_url' => $data->url(1),
                    'from' => $data->firstItem(),
                    'last_page' => $data->lastPage(),
                    'last_page_url' => $data->url($data->lastPage()),
                    'next_page_url' => $data->nextPageUrl(),
                    'path' => $data->path(),
                    'per_page' => $data->perPage(),
                    'prev_page_url' => $data->previousPageUrl(),
                    'to' => $data->lastItem(),
                    'total' => $data->total(),
                ];
            } else {
                $res['data'] = $data;
            }

            return Response::json($res, $code);
        });

        Response::macro('error', function ($msg = '', $code = 400) {
            $res = [];
            $msg_lang = "errors.$msg";
            $res['message'] = Lang::has($msg_lang) ? __($msg_lang) : $msg;
            $res['code'] = $msg;
            $res['status'] = $code;

            return Response::json($res, $code);
        });
    }
}
