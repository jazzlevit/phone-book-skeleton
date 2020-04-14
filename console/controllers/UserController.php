<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use console\models\User;
use yii\console\Controller;

/**
 * This is the command line system users tool.
 *
 * You can use this command to control system users.
 * For example:
 *
 * To create new admin account, you can run:
 *
 * ```
 * $ ./yii user/add new.user@example.com <pathphrase> <first_name> <last_name>
 *
 * ```
 *
 * To enable an account, you can run:
 *
 * ```
 * $ ./yii user/enable user@example.com
 * ```
 *
 * To disable an account, you can run:
 *
 * ```
 * $ ./yii user/disable user@example.com
 * ```
 *
 * To change a password, you can run:
 *
 * ```
 * $ ./yii user/passwd user@example.com <newpassword>
 * ```
 */
class UserController extends Controller
{

    /**
     * Index action.
     *
     * @return mixed the result of the action.
     */
    public function actionIndex()
    {
        $this->run('/help', ['user']);
    }

    /**
     * Creates new system user with role admin.
     *
     * @param  string  $email
     * @param  string  $pass
     * @param  string  $username
     *
     * @return integer Result
     */
    public function actionAdd($email, $pass, $username)
    {

        $user = new User();

        $user->username = $username;
        $user->email = $email;
        $user->role = \common\models\User::ROLE_ADMIN;
        $user->setPassword($pass);
        $user->generateAuthKey();

        if (!$user->hasErrors() && $user->validate() && $user->save(false)) {
            $successMessage = $this->ansiFormat("New system account has been created." . PHP_EOL, Console::FG_GREEN);
            echo $successMessage;
        } else {
            echo $this->ansiFormat("A problem occurred!" . PHP_EOL, Console::FG_RED);
            echo $this->parseErrorMessages($user->getErrors());
            return 1;
        }
    }

    /**
     * Enables system user.
     *
     * @param string $email
     *
     * @return integer
     */
    public function actionEnable($email)
    {
        if ($user = $this->findUserByEmail($email)) {
            $user->setAttribute('status', User::STATUS_ACTIVE);

            return $this->saveUser(
                $user,
                Yii::t('app', "System user {email} has been enabled.", ['email' => $email])
            );
        } else {
            return 1;
        }
    }

    /**
     * Disables a system user.
     *
     * @param  string $email
     *
     * @return integer
     */
    public function actionDisable($email)
    {
        if ($user = $this->findUserByEmail($email)) {
            $user->setAttribute('status', User::STATUS_DELETED);

            return $this->saveUser(
                $user,
                Yii::t('app', "System user {email} has been disabled.", ['email' => $email])
            );
        } else {
            return 1;
        }
    }

    /**
     * Changes password for a system user.
     *
     * @param  string $email
     * @param  string $password
     *
     * @return integer
     */
    public function actionPasswd($email, $password)
    {
        if ($user = $this->findUserByEmail($email)) {
            $user->setPassword($password);
            $user->generateAuthKey();

            return $this->saveUser(
                $user,
                Yii::t('app', "Password has been changed for system user {email}.", ['email' => $email])
            );
        } else {
            return 1;
        }
    }

    /**
     * Saves user model, outputs result messages.
     *
     * @param string $user
     * @param string $msgSuccess
     * @param string|boolean $msgError
     *
     * @return integer
     */
    protected function saveUser($user, $msgSuccess, $msgError = false)
    {
        $msgError = $msgError ? $msgError : Yii::t('app', "A problem occurred!");

        if ($user->validate() && $user->save(false) && !$user->hasErrors()) {
            $this->stdout($msgSuccess . PHP_EOL, Console::FG_GREEN);
        } else {
            $this->stderr($msgError . PHP_EOL, Console::FG_RED);
            $this->stderr($this->parseErrorMessages($user->getErrors()), Console::FG_RED);

            return 1;
        }
    }

    /**
     * Find user by email.
     *
     * @param string $email
     *
     * @return User|null
     */
    protected function findUserByEmail($email)
    {
        $user = User::findOne(['email' => $email]);

        if (empty($user)) {
            $this->stderr(
                Yii::t(
                    'app',
                    'System user with email: {email} is not found.',
                    ['email' => $email]
                ) . PHP_EOL, Console::FG_RED
            );
        }

        return $user;
    }

    /**
     * Converts array with error messages to a string.
     *
     * @param  array $errors
     *
     * @return string
     */
    protected function parseErrorMessages($errors)
    {
        $message = '';
        foreach ($errors as $error) {
            $message .= join("\n", $error);
        }
        return $message . "\n";
    }

}