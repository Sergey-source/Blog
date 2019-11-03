<?php
namespace App\Models;

use App\Models\BaseModel;
use Core\User;
use Core\DB;

class UserModel extends BaseModel
{
    private $table = 'users';

    public function signUp($email, $password, $first_name, $last_name)
    {
        $params = [
            'email' => $email,
            'password' => $password,
            'first_name' => $first_name,
            'last_name' => $last_name
        ];

        $this->db->insert($this->table, $params);
    }

    public function signIn($email, $password, $session)
    {
        if ($user = $this->getUserByEmail($email)) {
            if ($password == $user['password']) {
                $session_user = [
                    'email' => $email,
                    'password' => $password
                ];

                $session->set('user', $session_user);
            } 
        } 
    }

    public function getUserByEmail($email)
    {
        return ($user = $this->db->select($this->table, ['email' => $email], DB::FETCH_ONE)) ? $user : false;
    }

    public function signInUserBySession($session)
    {
        if ($session_user = $session->get('user')) {
            $user = $this->getUserByEmail($session_user['email']);
            
            if ($session_user['password'] == $user['password']) {
                return new User($user);
            } else {
                return null;
            }
        } else {
            return null;
        }
    } 
}
