<?php

namespace Turing\Backend\Exceptions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

use Illuminate\Validation\ValidationException;
use mysql_xdevapi\Exception;

/**
 * Class FailedHttValidationException
 * @package Turing\Backend\Exceptions
 */
class FailedHttValidationException extends ValidationException
{

    /**
     * The status code to use for the response.
     *
     * @var int
     */
    public $status = 400;

    public const USER_ERROR_CODES = [
        'USR_01' => 'Email or Password is invalid',
        'USR_02' => 'The field(s) are/is required',
        'USR_03' => 'The email is invalid',
        'USR_04' => 'The email already exists',
        'USR_05' => 'The email doesn\'t exist',
        'USR_06' => 'this is an invalid phone number',
        'USR_07' => 'this is too long',
        'USR_08' => 'this is an invalid Credit Card',
        'USR_09' => 'The Shipping Region ID is not number',
        'AUT_01' => 'Authorization code is empty.',
        'AUT_02' => 'Access Unauthorized.',
    ];

    public const CATEGORY_ERROR_CODES = [
        'CAT_01' => 'Don\'t exist category with this ID'
    ];

    public const DEPARTMENT_ERROR_CODES = [
        'DEP_01' => 'The ID is not a number',
        'DEP_02' => 'Don\'exist department with this ID'
    ];


    /**
     * Create a new exception instance.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param string $errorBag
     * @return void
     */
    public function __construct($validator, $response = null, $errorBag = 'default')
    {
        parent::__construct('The given data was invalid.');

        $this->response = $response;
        $this->errorBag = $errorBag;
        $this->validator = $validator;
    }

    /**
     * Create a new validation exception from a plain array of messages.
     *
     * @param array $messages
     * @return static
     */
    public static function withMessages(array $messages)
    {
        return new static(tap(ValidatorFacade::make([], []), function ($validator) use ($messages) {
            foreach ($messages as $key => $value) {
                foreach (Arr::wrap($value) as $message) {
                    $validator->errors()->add($key, $message);
                }
            }
        }));
    }

    /**
     * Get all of the validation error messages.
     *
     * @return array
     */
    public function errors()
    {
        if (empty($this->validator)) {
            return [];
        }
        $collect = collect($this->validator->errors()->messages());
        $collect = $collect->map(function ($message, $key) {
            $error = $this->getMessageCode($key, $message[0]);
            $result = [
                "code" => $error['code'],
                "message" => $error['message'],
                "field" => $key
            ];
            if (!in_array($error['code'], ['AUT_01', 'AUT_02'])) {
                $result["status"] = $this->code === 0 ? 400 : $this->code;
            }
            return $result;
        });
        // die(print_r($collect->toArray()));
        return $collect->toArray();
    }

    /**
     * Set the HTTP status code to be used for the response.
     *
     * @param int $status
     * @return $this
     */
    public function status($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set the error bag on the exception.
     *
     * @param string $errorBag
     * @return $this
     */
    public function errorBag($errorBag)
    {
        $this->errorBag = $errorBag;

        return $this;
    }

    /**
     * Set the URL to redirect to on a validation error.
     *
     * @param string $url
     * @return $this
     */
    public function redirectTo($url)
    {
        $this->redirectTo = $url;

        return $this;
    }

    /**
     * Get the underlying response instance.
     *
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function getResponses()
    {
        return $this->response;
    }

    private function getMessageCode(string $key, string $message)
    {
        $code = 0;

        if (strstr($message, 'has already been taken.')) {
            $code = 'USR_04';
            $message = static::USER_ERROR_CODES[$code];
        } elseif (strstr($message, 'doesn\'t exists')) {
            $code = 'USR_05';
            //$message = static::USER_ERROR_CODES[$code];
        } elseif (strstr($message, 'valid email address')) {
            $code = 'USR_03';
            $message = static::USER_ERROR_CODES[$code];
        } elseif (strstr($message, 'Email or Password is invalid.')) {
            $code = 'USR_01';
            $message = static::USER_ERROR_CODES[$code];
        } elseif (strstr($message, 'The password field is required')) {
            $code = 'USR_02';
            $message = static::USER_ERROR_CODES[$code];
        } elseif (strstr($message, 'field is required.')) {
            $code = 'USR_02';
            $message = static::USER_ERROR_CODES[$code];
        } elseif (strstr($message, 'may not be greater')) {
            $code = 'USR_07';
            $message = static::USER_ERROR_CODES[$code] . ' ' . $key;
        } elseif (strstr($message, 'email field is required.')) {
            $code = 'USR_02';
            $message = static::USER_ERROR_CODES[$code];
        } elseif (strstr($message, 'validation.ccn')) {
            $code = 'USR_08';
            $message = static::USER_ERROR_CODES[$code];
        } elseif (strstr($message, 'validation.phone')) {
            $code = 'USR_06';
            $message = static::USER_ERROR_CODES[$code];
        } elseif (strstr($message, 'Invalid permission grant for access token, please include email.')) {
            $code = 'USR_02';
        } elseif (strstr($message, 'The apikey is invalid.')) {
            $code = 'AUT_02';
            $message = static::USER_ERROR_CODES[$code];
            $this->code = 401;
        } elseif (strstr($message, 'Token has expired')) {
            $code = 'AUT_02';
            //$message = static::USER_ERROR_CODES[$code];
            $this->code = 401;
        } elseif (strstr($message, 'The token could not be parsed from the request')) {
            $code = 'AUT_01';
            $message = static::USER_ERROR_CODES[$code];
            $this->code = 401;
        } elseif (strstr($message, 'Could not decode token: Error while decoding to JSON: Malformed UTF-8 characters, possibly incorrectly encoded')) {
            $code = 'AUT_02';
            $message = static::USER_ERROR_CODES[$code];
            $this->code = 401;
        } elseif (strstr($message, 'The given data was invalid.')) {
            $code = 'AUT_01';
            $message = static::USER_ERROR_CODES[$code];
            $this->code = 401;
        }

        return compact('code', 'message');
    }
}
