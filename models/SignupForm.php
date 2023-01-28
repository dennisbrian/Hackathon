<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * SignupForm is the model behind the signup form.
 *
 * @property-read User|null $user
 *
 */
class SignupForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
        ];
    }

    public function signUp()
    {
        $model = new User;
        $db    = Yii::$app->db->beginTransaction();

        try{
            $pass_key = User::genPassKey();

            // check email unique
            $user = User::findOne([
                'email'     => $this->email,
                'is_delete' => 0
            ]);

            if (!empty($user)) {
                throw new \Exception("Email already existed.");
            }

            $user = $model->createUser([
                'first_name'   => $this->email,
                'last_name'    => $this->email,
                'email'        => $this->email,
                'password'     => $this->password,
                'role'         => 'user',
            ]);

            $db->commit();

            echo "[SUCCESS] " . $user->email . " created\n";
        }catch(\Exception $e)
        {
            $db->rollback();
            throw $e;
        }
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->email);
        }

        return $this->_user;
    }
}
