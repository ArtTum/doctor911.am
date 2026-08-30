<?php

namespace frontend\models;

use common\models\Doctor;
use common\models\Hospital;
use Yii;
use yii\base\Model;

/**
 * Public appointment form. This intentionally exposes no Subscribe database fields
 * other than the values that a visitor is allowed to submit.
 */
class SubscribeForm extends Model
{
    public $full_name;
    public $phone;
    public $description;
    public $doctor_id;
    public $hospital_id;
    public $verifyCode;
    public $website;
    public $form_token;

    /** @var string|null Values below are resolved from trusted database records. */
    public $doctorName;
    public $hospitalName;

    public function formName()
    {
        return 'Subscribe';
    }

    public function rules()
    {
        return [
            [['full_name', 'phone', 'verifyCode', 'form_token'], 'required'],
            [['full_name', 'phone', 'description'], 'trim'],
            [['full_name'], 'string', 'min' => 2, 'max' => 80],
            [['full_name'], 'match',
                'pattern' => "/^[\p{L}\p{M}][\p{L}\p{M}\s.'’\-]{1,79}$/u",
                'message' => Yii::t('frontend', 'Please enter a valid first and last name.'),
            ],
            [['phone'], 'string', 'max' => 30],
            [['phone'], 'validatePhone'],
            [['description'], 'string', 'max' => 1000],
            [['doctor_id', 'hospital_id'], 'integer', 'min' => 1],
            [['doctor_id'], 'exist',
                'targetClass' => Doctor::class,
                'targetAttribute' => ['doctor_id' => 'id'],
                'filter' => ['status' => 1],
            ],
            [['hospital_id'], 'exist',
                'targetClass' => Hospital::class,
                'targetAttribute' => ['hospital_id' => 'id'],
                'filter' => ['status' => 1],
            ],
            [['doctor_id'], 'validateSingleTarget'],
            [['website'], 'validateHoneypot'],
            [['form_token'], 'validateFormToken'],
            [['verifyCode'], 'captcha',
                'captchaAction' => 'site/captcha',
                'caseSensitive' => false,
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'full_name' => Yii::t('frontend', 'Full Name'),
            'phone' => Yii::t('frontend', 'Phone'),
            'description' => Yii::t('frontend', 'Description'),
            'verifyCode' => Yii::t('frontend', 'Verification Code'),
        ];
    }

    /**
     * Creates a short-lived signed token proving that the form was rendered by this application.
     */
    public static function createFormToken($timestamp = null)
    {
        $timestamp = $timestamp === null ? time() : (int) $timestamp;

        return Yii::$app->security->hashData(
            (string) $timestamp,
            Yii::$app->request->cookieValidationKey
        );
    }

    public function validatePhone($attribute)
    {
        $digits = preg_replace('/\D+/', '', (string) $this->$attribute);

        if (strncmp($digits, '374', 3) === 0) {
            $digits = substr($digits, 3);
        } elseif (strlen($digits) === 9 && $digits[0] === '0') {
            $digits = substr($digits, 1);
        }

        if (strlen($digits) !== 8 || preg_match('/^(\d)\1{7}$/', $digits)) {
            $this->addError($attribute, Yii::t('frontend', 'Please enter a valid Armenian phone number.'));
            return;
        }

        $this->$attribute = '+374' . $digits;
    }

    public function validateSingleTarget($attribute)
    {
        if (!empty($this->doctor_id) && !empty($this->hospital_id)) {
            $this->addError($attribute, Yii::t('frontend', 'Please select only one doctor or hospital.'));
        }
    }

    public function validateHoneypot($attribute)
    {
        if (trim((string) $this->$attribute) !== '') {
            $this->addError($attribute, Yii::t('frontend', 'The appointment request could not be verified.'));
        }
    }

    public function validateFormToken($attribute)
    {
        $timestamp = Yii::$app->security->validateData(
            (string) $this->$attribute,
            Yii::$app->request->cookieValidationKey
        );

        if ($timestamp === false || !ctype_digit($timestamp)) {
            $this->addError($attribute, Yii::t('frontend', 'The appointment request could not be verified.'));
            return;
        }

        $age = time() - (int) $timestamp;
        if ($age < 2 || $age > 7200) {
            $this->addError($attribute, Yii::t('frontend', 'The appointment form has expired. Please reload the page.'));
        }
    }
}
