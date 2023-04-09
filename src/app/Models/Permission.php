<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    public const CAN_VIEW_CATEGORY_TREE_FORCE = 'view_category_tree_force';
    public const CAN_CREATE_CATEGORY = 'create_category';
    public const CAN_UPDATE_CATEGORY = 'update_category';
    public const CAN_DELETE_CATEGORY = 'delete_category';

    public const DEFAULT_DIRECTOR_PERMISSIONS = [
        self::CAN_CREATE_CATEGORY,
        self::CAN_UPDATE_CATEGORY,
        self::CAN_DELETE_CATEGORY,
    ];
    public const DEFAULT_ADMIN_PERMISSIONS = [
        self::CAN_VIEW_CATEGORY_TREE_FORCE,
        self::CAN_CREATE_CATEGORY,
        self::CAN_UPDATE_CATEGORY,
        self::CAN_DELETE_CATEGORY,
    ];
}
