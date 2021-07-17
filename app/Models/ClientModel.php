<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class ClientModel extends Model
{
    protected $table = 'client';
    protected $allowedFields = [
        'name',
        'email',
        'retainer_fee'
    ];

    protected $updateField = 'update_at';

    public function findClientById($id)
    {
        $client = $this->asArray()->where(['id' => $id])->first();

        if (!$client)
            throw new Exception('ID pengguna tidak ditemukan');

        return $client;
    }
}
