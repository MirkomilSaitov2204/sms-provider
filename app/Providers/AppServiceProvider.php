<?php

namespace App\Providers;

use App\Domain\Contracts\ProjectResolverInterface;
use App\Domain\Contracts\ProjectServiceInterface;
use App\Domain\Contracts\ProviderResolverInterface;
use App\Domain\Contracts\SmsDispatchServiceInterface;
use App\Domain\Contracts\SmsGatewayServiceInterface;
use App\Domain\Contracts\SmsServiceInterface;
use App\Infrastructure\Services\ProjectResolverService;
use App\Infrastructure\Services\ProjectService;
use App\Infrastructure\Services\ProviderResolverService;
use App\Infrastructure\Services\SmsDispatchService;
use App\Infrastructure\Services\SmsGatewayService;
use App\Infrastructure\Services\SmsService;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProviderResolverInterface::class, ProviderResolverService::class);
        $this->app->bind(SmsGatewayServiceInterface::class, SmsGatewayService::class);
        $this->app->bind(ProjectResolverInterface::class, ProjectResolverService::class);
        $this->app->bind(ProjectServiceInterface::class, ProjectService::class);
        $this->app->bind(SmsServiceInterface::class, SmsService::class);
        $this->app->bind(SmsDispatchServiceInterface::class, SmsDispatchService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
