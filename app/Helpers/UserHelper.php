<?php

namespace App\Helpers;

class UserHelper
{

    public static function getUserId($id): int
    {
        return $id && $id !== '{id}' ? $id : auth('api')->user()->id;
    }

    public  static function isCurrentUserOrHasAccess($id, $permission): bool
    {
        $user = auth('api')->user();

        if (!$id) {
            return false;
        }

        $id = UserHelper::getUserId($id);

        return $user->can($permission) || $user->id === $id;
    }

}
