<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\UserRole;

class UserRoleQuery extends Model
{
	//ROLE
	CONST ROLE_MASTER = 'master';
	CONST ROLE_ADMIN = 'admin';
	CONST ROLE_SUBADMIN   = 'subadmin';
	CONST ROLE_SUPERADMIN = 'superadmin';
	CONST ROLE_USER       = 'user';
	//MODULE
	CONST SUB_ADMIN              = 'sub-admin';
	CONST MOVIES                 = 'movies';

	public static function getAllPermission($platform='')
	{
		$permission = [];

		$permission[self::SUB_ADMIN]["name"]              = self::SUB_ADMIN;
		$permission[self::MOVIES]["name"]              = self::MOVIES;

		//for permission display purpose
		$permission[self::SUB_ADMIN]["desc"]              = "Manage Subadmin Management";
		$permission[self::MOVIES]["desc"]              = "Manage Movies Management";

		//for permission grouping purpose
		$permission[self::SUB_ADMIN]["group"]             = ['group' => 'admin'];
		$permission[self::MOVIES]["group"]             = ['group' => 'admin'];

		return $permission;
	}

	public static function getPermissionList()
	{
		return [
			'true'  => Yii::t('app','true'),
			'false' => Yii::t('app', 'false'),
		];
	}
}
