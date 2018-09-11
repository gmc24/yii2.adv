<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property string $avatar
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @mixin  \mohorev\file\UploadImageBehavior
 */
class User extends ActiveRecord implements IdentityInterface
{
    private $_password;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATS_LABELS = [
        self::STATUS_ACTIVE => 'активен',
        self::STATUS_DELETED => 'удален'
    ];

    const AVATAR_FULL = 'full';
    const AVATAR_THUMB = 'thumb';

    const SCEN_ADMIN_CREATE = 'admin_create';
    const SCEN_ADMIN_UPDATE = 'admin_update';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $host = Yii::$app->params['backend.scheme'].Yii::$app->params['backend.domen'];
        return [
            TimestampBehavior::className(),
            [
                'class' => \mohorev\file\UploadImageBehavior::class,
                'attribute' => 'avatar',
                'scenarios' => [self::SCEN_ADMIN_CREATE, self::SCEN_ADMIN_UPDATE],
                'placeholder' => '@frontend/web/upload/avatar/anonym.png',
                'path' => '@frontend/web/upload/avatar/{id}',
//                'url' => '@web/upload/avatar/{id}',
                'url' => $host.'/upload/avatar/{id}',
                'thumbs' => [
                    self::AVATAR_FULL => ['width' => 150, 'height' => 150, 'quality' => 80],
                    self::AVATAR_THUMB => ['width' => 32, 'height' => 32, 'quality' => 60],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['email', 'email', 'on' => [self::SCEN_ADMIN_CREATE, self::SCEN_ADMIN_UPDATE]],
            [['username', 'email'], 'unique', 'on' => [self::SCEN_ADMIN_CREATE, self::SCEN_ADMIN_UPDATE]],
            ['password', 'string', 'min' => 6, 'on' => self::SCEN_ADMIN_CREATE],
            ['avatar', 'image', 'extensions' => 'jpg, jpeg, gif, png', 'on' => [self::SCEN_ADMIN_CREATE, self::SCEN_ADMIN_UPDATE]],
            [['username', 'email', 'password'], 'required', 'on' => self::SCEN_ADMIN_CREATE],
            [['username', 'email'], 'required', 'on' => self::SCEN_ADMIN_UPDATE],
        ];
    }

    /**
     * @return \Yii\db\ActiveQuery
     */
    public function getProjectUsers(){
        return $this->hasMany(ProjectUser::className(), ['user_id' => 'id']);
    }

    /**
     * @return \Yii\db\ActiveQuery
     */
    public function getProjects(){
        return $this->hasMany(Project::className(), ['id' => 'project_id']) ->via('projectUsers');
    }

    public function beforeSave($insert)
    {
        if ($insert) $this->generateAuthKey();
        return parent::beforeSave($insert)? true:false;
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        if ($password) $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        $this->_password = $password;
    }
   public function getPassword()
    {
        return $this->_password;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
