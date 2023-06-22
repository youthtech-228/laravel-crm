<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersIndex extends Component
{
    use WithPagination;

    public $searchTerm;

    protected $paginationTheme = 'bootstrap';
    
    public function getPermissionList($roleId) {
        $permissions = DB::table('role_has_permissions')
            ->join('permissions', 'role_has_permissions.permission_id', 'permissions.id')
            ->where('role_id', $roleId)
            ->select('permissions.id as PermId', 'role_has_permissions.role_id as roleId', 'permissions.name as permName')
            ->get();
        Log::info($permissions);
        return $permissions;
    }

    public function render()
    {
        // Log::alert(json_encode(Auth::user()->id));
        /**
         * role_id = 3: client, role_id=4: user
         * if the current user is client role, only return users who's role is user 
         * if the current user is administrator role, return all users list
         * */
        $searchTerm = '%'.$this->searchTerm.'%';
        $currentUserRole = DB::table('model_has_roles')->where('model_id', Auth::user()->id)->first();
        if ($currentUserRole->role_id == 3) {
            $users = DB::table('users')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('users.client', Auth::user()->id)
                ->whereNull('users.deleted_at')
                ->where('roles.id', '=', 4)
                ->where(function($query) use ($searchTerm) {
                    return $query->where('users.name', 'like', $searchTerm)
                                ->orWhere('users.email', 'like', $searchTerm);
                })
                ->orderBy('users.id', 'desc')
                ->select('users.*', 'roles.id as roleId', 'roles.name as roleName')
                ->paginate();
        } else {
            $users = DB::table('users')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('roles.id', '!=', 1)
                ->whereNull('users.deleted_at')
                ->where(function($query) use ($searchTerm) {
                    return $query->where('users.name', 'like', $searchTerm)
                                ->orWhere('users.email', 'like', $searchTerm);
                })
                ->orderBy('users.id', 'desc')
                ->select('users.*', 'roles.id as roleId', 'roles.name as roleName')
                ->paginate();
            // $users = User::where('name', 'like', $searchTerm)
            //     ->orWhere('email', 'like', $searchTerm)
            //     ->orderBy('id', 'desc')
            //     ->with(['permissions', 'roles', 'providers'])
            //     ->paginate();
        }
        // dd($users);
        Log::warning($users);

        return view('livewire.users-index', compact('users'));
    }
}
