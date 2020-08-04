<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

        /**
         * This namespace is applied to your controller routes.
         *
         * In addition, it is set as the URL generator's root namespace.
         *
         * @var string
         */
        protected $namespace = 'App\Http\Controllers';

        /**
         * Define your route model bindings, pattern filters, etc.
         *
         * @return void
         */
        public function boot()
        {
                //

                parent::boot();
        }

        /**
         * Define the routes for the application.
         *
         * @return void
         */
        public function map()
        {
                $this->mapApiRoutes();

                $this->mapWebRoutes();

                //
        }

        /**
         * Define the "web" routes for the application.
         *
         * These routes all receive session state, CSRF protection, etc.
         *
         * @return void
         */
        protected function mapWebRoutes()
        {
                Route::middleware('web')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/web.php'));

                Route::middleware('web')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/users/auth.php'));

                Route::middleware('web')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/la.php'));
        }

        /**
         * Define the "api" routes for the application.
         *
         * These routes are typically stateless.
         *
         * @return void
         */
        protected function mapApiRoutes()
        {
                Route::prefix('api')
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/api.php'));
                Route::prefix('api')
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/surveyApi.php'));
                Route::prefix('api')
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/localAuthorityApi.php'));
                Route::prefix('api')
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/eplAPI.php'));
                Route::prefix('api')
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/commetyApi.php'));
                Route::prefix('api')
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/environmentOfficersAPI.php'));
                Route::prefix('api')
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/remarkAPI.php'));
                Route::prefix('api')
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/inspectionAPI.php'));

                Route::prefix('api')
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/inspectionRemarkAPI.php'));
                Route::prefix('api')
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/inspectionAttaAPI.php'));
                Route::prefix('api')
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/eplPaymentAPI.php'));
                Route::prefix('cashier')
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/cashierPaymentAPI.php'));
                Route::prefix('api')
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/approvalAPI.php'));
                Route::prefix('api')
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/searchAPI.php'));
                Route::prefix('api')
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/ClientAPI.php'));
        }
}
