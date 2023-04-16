<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    public const CAN_VIEW_CATEGORY_TREE_FORCE = 'view_category_tree_force';
    public const CAN_CREATE_CATEGORY = 'create_category';
    public const CAN_UPDATE_CATEGORY = 'update_category';
    public const CAN_DELETE_CATEGORY = 'delete_category';

    public const CAN_CREATE_LEAD_SOURCE = 'create_lead_source';
    public const CAN_UPDATE_LEAD_SOURCE = 'update_lead_source';
    public const CAN_DELETE_LEAD_SOURCE = 'delete_lead_source';

    public const CAN_CREATE_LEAD_TYPE = 'create_lead_type';
    public const CAN_UPDATE_LEAD_TYPE = 'update_lead_type';
    public const CAN_DELETE_LEAD_TYPE = 'delete_lead_type';

    public const CAN_CREATE_LEAD = 'create_lead';
    public const CAN_UPDATE_LEAD = 'update_lead';
    public const CAN_DELETE_LEAD = 'delete_lead';

    public const CAN_CREATE_PERSON = 'create_person';
    public const CAN_UPDATE_PERSON = 'update_person';
    public const CAN_DELETE_PERSON = 'delete_person';

    public const CAN_CREATE_ORGANIZATION = 'create_organization';
    public const CAN_UPDATE_ORGANIZATION = 'update_organization';
    public const CAN_DELETE_ORGANIZATION = 'delete_organization';

    public const CAN_CREATE_PRODUCT = 'create_product';
    public const CAN_UPDATE_PRODUCT = 'update_product';
    public const CAN_DELETE_PRODUCT = 'delete_product';

    public const DEFAULT_DIRECTOR_PERMISSIONS = [
        self::CAN_CREATE_CATEGORY,
        self::CAN_UPDATE_CATEGORY,
        self::CAN_DELETE_CATEGORY,
        self::CAN_CREATE_LEAD_SOURCE,
        self::CAN_UPDATE_LEAD_SOURCE,
        self::CAN_DELETE_LEAD_SOURCE,
        self::CAN_CREATE_LEAD_TYPE,
        self::CAN_UPDATE_LEAD_TYPE,
        self::CAN_DELETE_LEAD_TYPE,
        self::CAN_CREATE_LEAD,
        self::CAN_UPDATE_LEAD,
        self::CAN_DELETE_LEAD,
        self::CAN_CREATE_PERSON,
        self::CAN_UPDATE_PERSON,
        self::CAN_DELETE_PERSON,
        self::CAN_CREATE_ORGANIZATION,
        self::CAN_UPDATE_ORGANIZATION,
        self::CAN_DELETE_ORGANIZATION,
        self::CAN_CREATE_PRODUCT,
        self::CAN_UPDATE_PRODUCT,
        self::CAN_DELETE_PRODUCT,
    ];
}
