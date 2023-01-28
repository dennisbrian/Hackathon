<?php

namespace app\commands;

use Yii;
use yii\console\Exception;
use yii\console\Controller;
use app\models\UserRole;
use app\models\User;

class SystemController extends Controller
{
	public function actionCreateUser()
	{
		//create new user
		$role_list  = UserRole::find()->all();

		if(empty($role_list)) {
			echo "> [ERR] Empty User Role\n";
			exit;
		}

		echo "\n";
		echo "### User Role ###\n";
		echo "<Role Name> - <Role Label>\n";

		$roleList = [];
		foreach($role_list as $a) {
			$roleList[] = $a->name;
			echo " [{$a->name}] - {$a->label}\n";
		}

		echo "\n";
		echo "> Enter Role Name : ";

		$handle = fopen("php://stdin","r");
		$role   = trim(fgets($handle));

		if(empty($role)) {
			echo "> No role enter. Abort.\n";
			exit;
		}

		if(!in_array(trim($role), $roleList)) {
			echo "\n Exit. Wrong Role Name";
			exit;
		}

		echo "> Enter Email : ";

		$email = trim(fgets($handle));

		if(empty($email)) {
			echo "> No email enter. Abort.\n";
			exit;
		}

		echo "> Enter Password : ";

		$password = trim(fgets($handle));

		if(empty($password)) {
			echo "> No password enter. Abort.\n";
			exit;
		}

		fclose($handle);

		$model = new User;
		$db    = Yii::$app->db->beginTransaction();

		try{
			$pass_key = User::genPassKey();

			// check email unique
			$user = User::findOne([
				'email'     => $email,
				'is_delete' => 0
			]);

			if (!empty($user)) {
				throw new \Exception("Email already existed.");
			}

			$user = $model->createUser([
				'first_name'   => $email,
				'last_name'    => $email,
				'email'        => $email,
				'password'     => $password,
				'role'         => $role,
			]);

			$db->commit();

			echo "[SUCCESS] " . $user->email . " created\n";
		}catch(\Exception $e)
		{
			$db->rollback();
			throw $e;
		}

		return true;
	}
}
