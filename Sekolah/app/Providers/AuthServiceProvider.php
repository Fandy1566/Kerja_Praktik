<?php

namespace App\Providers;
use App\Models\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('Admin', function (User $user) {
            return $user->isAdmin();
        });
        Gate::define('kepala_sekolah', function (User $user) {
            return $user->isKepalaSekolah() ||$user->isWakilKepalaSekolah();
        });
        Gate::define('guru', function (User $user) {
            return $user->isGuruTetap() ||$user->isGuruHonorer();
        });
        Gate::define('dihapus', function (User $user) {
            return $user->isDihapus();
        });
    }
}
