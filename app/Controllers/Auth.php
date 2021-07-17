<?php 

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use ReflectionException;

class Auth extends BaseController
{
    /**
     * Register pengguna baru
     * @return Response
     * @throws ReflectionException
     */
    public function register()
    {
        $rules = [
            'name ' => 'required',
            'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[user.email]',
            'password' => 'required|min_length[8]|max_length[255]'
        ];

        $input = $this->getRequestInput($this->request);
        if (!$this->validateRequest($input, $rules)) {
            return $this->getResponse(
                $this->validator->getErrors(),
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }
        $userModel = new UserModel();
        $userModel->save($input);

        return $this->getJwtForUser($input['email'],ResponseInterface::HTTP_CREATED);
    }

    /**
     * Autentikasi pengguna 
     * @return response
     */

    public function login()
    {
        $rules = [
            'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[user.email]',
            'password' => 'required|min_length[8]|max_length[255]|validateUser[email, password]'
        ];

        $errors = [
            'password' => [
                'validateUser' => 'Invalid login credentials provided'
            ]
        ];

        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules, $errors)) {
            return $this
                ->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        }
        return $this->getJwtForUser($input['email']);
    }

    private function getJwtForUser(string $emailAddress, int $responseCode = ResponseInterface::HTTP_OK)
    {
        try {
            $model = new UserModel();
            $user = $model->findUserByEmail($emailAddress);
            unset($user['password']);

            helper('jwt');

            return $this->getResponse(
                [
                    'message'   => 'Autentikasi pengguna berhasil',
                    'user'      => $user,
                    'access_token' => getSignedJwtUser($emailAddress)
                ]
            );
        } catch (Exception $exception) {
            return $this->getResponse(
                [
                    'error'     => $exception->getMessage(),
                ],
                $responseCode
            );
        }
    }
}