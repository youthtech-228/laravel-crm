<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    /**
     * Default Permissions of the Application.
     */
    public static function defaultPermissions()
    {
        return [
            'view_users',
            'add_users',
            'edit_users',
            'delete_users',
            'restore_users',
            'block_users',

            'view_roles',
            'add_roles',
            'edit_roles',
            'delete_roles',
            'restore_roles',

            'view_customers',
            'add_customers',
            'edit_customers',
            'delete_customers',
            'restore_customers',
            'block_customers',

        ];
    }

    /**
     * Name should be lowercase.
     *
     * @param  string  $value  Name value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
}
