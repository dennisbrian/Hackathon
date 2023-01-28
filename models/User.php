<?php

namespace app\models;

use Yii;
use app\models\UserRole;
use app\models\UserSalesTarget;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $hash_id
 * @property string|null $group_tag
 * @property string|null $first_name
 * @property string|null $middle_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string|null $dob
 * @property string|null $phone_code
 * @property string|null $phone_number
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $postcode
 * @property string|null $country_code
 * @property string|null $country_name
 * @property string|null $bank_account_name
 * @property string|null $bank_account_no
 * @property string|null $bank_bsb
 * @property string|null $password
 * @property string|null $password_key
 * @property string|null $access_token
 * @property string|null $role
 * @property int|null $is_signup_email_sent
 * @property int $is_suspend
 * @property string $created_at
 * @property string|null $updated_at
 * @property int|null $is_delete
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    const JWT_USERID = 'user_id';
    const JWT_TOKEN  = 'access_token';
    const JWT_GOOGLE_AUTH  = 'google_auth_secret';
    const JWT_EMAIL  = 'email';

    public $authKey;
    public $jwt_token;

    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dob', 'created_at', 'updated_at'], 'safe'],
            [['is_suspend', 'is_delete'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'email', 'phone_code', 'phone_number', 'address', 'city', 'state', 'postcode', 'country_code', 'country_name', 'role'], 'string', 'max' => 100],
            [['password', 'password_key', 'access_token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'dob' => 'Dob',
            'phone_code' => 'Phone Code',
            'phone_number' => 'Phone Number',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'postcode' => 'Postcode',
            'country_code' => 'Country Code',
            'country_name' => 'Country Name',
            'password' => 'Password',
            'password_key' => 'Password Key',
            'access_token' => 'Access Token',
            'role' => 'Role',
            'is_signup_email_sent' => 'Is Signup Email Sent',
            'is_suspend' => 'Is Suspend',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_delete' => 'Is Delete',
        ];
    }

    public static function findIdentity($id)
    {
        $user = User::findOne(['id' => $id, 'is_delete' => 0]);
        if (empty($user))
            return null;

        return $user;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        if (empty($token)) {
            return null;
        }

        try {
            self::validateJwtToken($token);
            $resp = self::verifyJwtToken($token);
            if (!isset($resp[self::JWT_USERID]) || !isset($resp[self::JWT_TOKEN])) {
                return null;
            }
            $user = self::findIdentity($resp[self::JWT_USERID]);
            if (empty($user) || $user->access_token != $resp[self::JWT_TOKEN]) {
                return null;
            }
            return $user;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function findByUsername($email)
    {
        $user = User::findOne(['email' => $email]);
        if (empty($user)){
            return null;
        }

        return $user;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        $raw = User::genPassWithKey($password,$this->password_key);
        $hash = User::hashPassword($password,$this->password_key);

        if (password_verify($raw, $this->password)) {
            return true;
        } else {
            return false;
        }
    }

    // Begin Token
    public function updateAccessToken()
    {
        $token = uniqid();
        $this->access_token = $token;
        $this->jwt_token = self::genJwtToken($this->id,$token);

        $user = User::findOne($this->id);
        $user->access_token = $this->access_token;
        $user->update(false, ['access_token']);
        return $this;
    }

    public function getAccessToken()
    {
        return self::genJwtToken($this->id, $this->access_token, Yii::$app->params['jwt_expiry']);
    }
    // End Token

    // Begin Password
    public static function genPassKey()
    {
        return crypt(md5(date('YmdHis')),uniqid());
    }

    public static function genPassWithKey($password,$key)
    {
        return $key.md5($password.$key).$key;
    }

    public static function hashPassword($password,$key)
    {
        $string = User::genPassWithKey($password, $key);
        return password_hash($string, PASSWORD_DEFAULT);
    }

    public static function genSecondaryPass($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    // End Password

    public function createUser($params)
    {
        $attribute = [
            'first_name'           => null,
            'middle_name'          => null,
            'last_name'            => null,
            'email'                => null,
            'dob'                  => null,
            'phone_code'           => null,
            'phone_number'         => null,
            'address'              => null,
            'city'                 => null,
            'state'                => null,
            'postcode'             => null,
            'country_code'         => null,
            'country_name'         => null,
            'password'             => null,
            'password_key'         => null,
            'role'                 => null,
        ];

        foreach($attribute as $key => $value) {
            if(isset($params[$key])) {
                $attribute[$key] = $params[$key];
            }
        }

        $pass_key = self::genPassKey();

        $model = new User;
        $model->first_name           = $attribute['first_name'];
        $model->middle_name          = $attribute['middle_name'];
        $model->last_name            = $attribute['last_name'];
        $model->email                = $attribute['email'];
        $model->dob                  = $attribute['dob'];
        $model->phone_code           = $attribute['phone_code'];
        $model->phone_number         = $attribute['phone_number'];
        $model->address              = $attribute['address'];
        $model->city                 = $attribute['city'];
        $model->state                = $attribute['state'];
        $model->postcode             = $attribute['postcode'];
        $model->country_code         = $attribute['country_code'];
        $model->country_name         = $attribute['country_name'];
        $model->password             = self::hashPassword($attribute['password'], $pass_key);
        $model->password_key         = $pass_key;
        $model->role                 = $attribute['role'];

        if(!$model->save()) {
            throw new \Exception(current($model->getFirstErrors()));
        }

        return $model;
    }

    public function changePassword($params)
    {
        $attribute = [
            'password' => null,
        ];

        foreach($attribute as $key => $value) {
            if(isset($params[$key])) {
                $attribute[$key] = $params[$key];
            }
        }

        $pass_key = self::genPassKey();

        $this->password_key = $pass_key;
        $this->password     = self::hashPassword($attribute['password'], $pass_key);
        $this->update(false,['password', 'password_key']);

        return $this;
    }

    public function getRoleString()
    {
        $data = UserRole::findOne(['name' => $this->role]);
        return $data->label;
    }

    public function getFormatData()
    {
        return ArrayHelper::toArray($this, [
            'app\models\User' => [
                'id',
                'first_name',
                'middle_name',
                'last_name',
                'email',
                'phone_code',
                'phone_number',
                'access_token',
                'role',
            ],
        ]);
    }
}
