<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 所有控制器动作都需要登录后才能访问
        $this->middleware('auth');
        // 只有verify动作使用 signed 中间件进行认证，signed中间件是一种由框架提供的很方便的URL签名认证方式
        $this->middleware('signed')->only('verify');
        // 对 verify 和 resend 的动作做了频率限制，throttle 中间件是框架提供的访问频率限制功能，throttle中间件会接受两个参数，这两个参数决定了在给定的分钟内可以进行的最大请求数。在这个例子中。限定了这两个动作访问频率是1分钟内不能超过6次
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
