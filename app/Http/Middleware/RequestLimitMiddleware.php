<?php

namespace App\Http\Middleware;

use App\Models\RequestCount;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestLimitMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $r, Closure $next): Response
    {

        $userId = $r->user_id;
        $TheUser = User::find($r->user_id);
        // Check if the user has exceeded the request limit
        $requestCount = RequestCount::where('user_id', $userId)
            ->whereDate('created_at', today())
            ->first();
        if ($TheUser->active == 0) {
            // The user has exceeded the request limit
            return response()->json(['message' => 'يجب تأكيد الحساب أولاً  '], 403);
        }
        if ($requestCount && $requestCount->request_count >= 100) {
            // The user has exceeded the request limit
            return response()->json(['message' => 'تم الوصول للحد الأقصى للتاكيدات اليوم'], 429);
        }
        // Update or create the request count for the user
        if ($requestCount) {
            $requestCount->increment('request_count');
        } else {
            RequestCount::create([
                'user_id' => $userId,
                'request_count' => 1,
            ]);
        }

        return $next($r);

    }
}
