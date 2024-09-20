<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticationed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!empty(session('user_code'))) {

            toastr()->error('Vui Lòng Đăng Xuất Trước Khi Sử Dụng Tính Năng Này');

            return back();
        }

        return $next($request);
    }
}
