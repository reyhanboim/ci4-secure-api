<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class UserModel extends Model
{
    protected $table = 'user';
    protected $allowedFields = [
        'name',
        'email',
        'password',
    ];

    protected $updateField = [
        'update_at'
    ];

    protected $beforeInsert = [
        'beforeInsert'
    ];

    protected $beforeUpdate = [
        'beforeUpdate'
    ];

    /**
     * Menjalankan fungsi terhadap entiti data pada user
     * sebelum dimasukkan ke dalam database.
     * Fungsi yang dijalankan adalah meng-hash entiti password
     */
    protected function beforeInsert(array $data): array
    {
        return  $this->getUpdateDataWithHasedPassword($data);
    }

    protected function beforeUpdate(array $data): array
    {
        return  $this->getUpdateDataWithHasedPassword($data);
    }

    private function getUpdateDataWithHasedPassword(array $data): array
    {
        if (isset($data['data']['password'])) {
            $plainTextPassword = $data['data']['password'];
            $data['data']['password'] = $this->hashPassword($plainTextPassword);
        }
        return $data;
    }

    private function hashPassword(string $plainTextPassword): string
    {
        return password_hash($plainTextPassword, PASSWORD_BCRYPT);
    }

    public function findUserByEmail(string $email)
    {
        $user = $this->asArray()->where(['email' => $email])->first();

        if (!$user) 
            throw new Exception('Pengguna dengan email tersebut belum terdaftar');
        
        return $user;
    }
}
