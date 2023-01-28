<?php

namespace app\commands;

use Yii;
use ReflectionClass;
use ReflectionProperty;
use yii\console\Exception;
use yii\console\Controller;
use app\models\UserRole;
use app\models\User;
use app\models\UserRoleQuery;

class RbacController extends Controller
{
	protected $_rules;

	public function actionIndex($platform='')
	{
		$auth = $this->getAuth();
		$role_query = UserRole::find();
		$role_query->andWhere(['is_delete' => 0]);
		$user_role = $role_query->all();
		$user_permission = UserRoleQuery::getAllPermission($platform);

		if(empty($user_role)){
			echo "User role is not configure in database yet\n";
			return true;
		}

		if(empty($user_permission)){
			echo "Permission role is not configure yet\n";
			return true;
		}

		echo "Initial ... ";
		foreach($user_role as $role){
			$this->createAuthItem('role', $role->name);
		}

		foreach ($user_permission as $permission => $value) {
			$this->createAuthItemPermission('permission', $value['name'], $value['group'], $value['desc']);
		}

		// initialize to admin/sub-admin
		foreach ($auth->getPermissions() as $key => $value) {
			if (!isset($value->data['group'])) {
				continue ;
			}

			$group = $value->data['group'];
			$role = ['subadmin','superadmin','admin'];
			$user = User::find()->andWhere(['in','role',$role])->andWhere(['is_delete' => 0 ]);
			foreach ($user->each() as $user) {
				if ($value && !$auth->checkAccess($user->id, $key)) {
					$perm = $auth->getPermission($key);
					if ($perm) {
						$auth->assign($perm, $user->id);
					}
				} else if (!$value && $auth->checkAccess($user->id, $key)) {
					$perm = $auth->getPermission($key);
					if ($perm) {
						$auth->revoke($perm, $user->id);
					}
				}
			}
		}
		echo "[DONE]\n";
	}

	public function actionReset()
	{
		$auth = $this->getAuth();
		$auth->removeAll();
	}

	protected function getAuth()
	{
		return Yii::$app->authManager;
	}

	protected function createAuthItem($type, $name, $rule=null, $group=null)
	{
		if (!in_array($type, ['role', 'permission']))
			throw new Exception("Invalid role type");

		$auth = $this->getAuth();
		if ($type == 'role') {
			$auth_item = $auth->getRole($name);

			if (empty($auth_item)) {
				$auth_item = $auth->createRole($name);
				$auth->add($auth_item);
			}
		} else if ($type == 'permission') {
			$auth_item = $auth->getPermission($name);
			if (empty($auth_item)) {
				$auth_item = $auth->createPermission($name);
				if (isset($rule)) {
					$auth_item->ruleName = $rule->name;
				}
				$auth_item->data = $group;
				$auth->add($auth_item);
			}
		}
		return $auth_item;
	}

	protected function createAuthItemPermission($type, $name, $group, $desc)
	{
		$auth = $this->getAuth();
		$auth_item = $auth->getPermission($name);

		if ($type == 'permission') {
			if (empty($auth_item)) {
				$auth_item = $auth->createPermission($name);
				$auth_item->data = $group;
				$auth_item->description = $desc;
				$auth->add($auth_item);
			}
		}
		return $auth_item;
	}

}
