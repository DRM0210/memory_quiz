<?php

namespace App\Providers;

use App\Models\CompanyInfo;
use App\Models\Student;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    View::composer(['layouts.commonMaster', 'layouts.sections.menu.verticalMenu'], function ($view) {
      $view->with('company', CompanyInfo::first());
    });

    View::composer('layouts.sections.menu.verticalMenu', function ($view) {
      $studentStats = null;
      if (auth()->guard('web')->check()) {
        $studentStats = [
          'total' => Student::count(),
          'active' => Student::where('status', 1)->count(),
          'inactive' => Student::where('status', 0)->count(),
        ];
      }
      $view->with('studentStats', $studentStats);
    });
  }
}
