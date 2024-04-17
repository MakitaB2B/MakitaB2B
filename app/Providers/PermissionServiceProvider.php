<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;

use App\Models\Admin\Permission;

use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //create Access Module blade directive
        Blade::directive('module',function($module){
            return "<?php if(Auth::guard('admin')->check() &&  Auth::guard('admin')->user()->hasModuleAccess({$module})) { ?>";
        });
        Blade::directive('endmodule',function($module){
            return "<?php } ?>";
        });

        //create role blade directive
        Blade::directive('role',function($role){
            return "<?php if(Auth::guard('admin')->check() &&  Auth::guard('admin')->user()->hasRole({$role})) { ?>";
        });
        Blade::directive('endrole',function($role){
            return "<?php } ?>";
        });

        //create permission blade directive
        Blade::directive('permission',function($permission){
            return "<?php if(Auth::guard('admin')->check() &&  Auth::guard('admin')->user()->hasPermission({$permission})) { ?>";
        });
        Blade::directive('endpermission',function($permission){
            return "<?php } ?>";
        });
    }
}
