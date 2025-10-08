<?php

namespace App\Http\Middleware;

use App\Models\Application;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetApplicationContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $appSlug = null): Response
    {
        // Skip if multi-app is disabled
        if (!Application::isEnabled()) {
            return $next($request);
        }

        if (!auth()->check()) {
            return $next($request);
        }

        // Determine application from parameter, subdomain, or session
        $application = $this->determineApplication($request, $appSlug);

        if ($application) {
            // Check if user has access
            if (!auth()->user()->hasAccessToApplication($application->slug)) {
                abort(403, 'Sie haben keinen Zugriff auf diese Anwendung.');
            }

            // Set application context
            session(['current_application_id' => $application->id]);

            // Share with views
            view()->share('currentApplication', $application);

            // Make available in Inertia
            \Inertia\Inertia::share('currentApplication', [
                'id' => $application->id,
                'name' => $application->name,
                'slug' => $application->slug,
                'icon' => $application->icon,
                'color' => $application->color,
            ]);

            // Update last accessed
            auth()->user()->touchApplicationAccess($application->id);
        }

        return $next($request);
    }

    /**
     * Determine which application is being accessed
     */
    protected function determineApplication($request, ?string $appSlug)
    {
        // 1. Try from middleware parameter
        if ($appSlug) {
            $app = Application::where('slug', $appSlug)
                ->where('is_active', true)
                ->first();
            if ($app) {
                return $app;
            }
        }

        // 2. Try from subdomain
        $host = $request->getHost();
        $parts = explode('.', $host);
        if (count($parts) > 2) {
            $subdomain = $parts[0];
            $app = Application::where('subdomain', $subdomain)
                ->where('is_active', true)
                ->first();
            if ($app) {
                return $app;
            }
        }

        // 3. Fallback to session
        $appId = session('current_application_id');
        if ($appId) {
            return Application::find($appId);
        }

        // 4. Default to first application (for single-app mode)
        return Application::active()->ordered()->first();
    }
}
