<?php

    namespace tests;
    
    use PHPUnit\Framework\TestCase;
    use SWServices\AccountUser\AccountUserService as AccountUserService;
    use Exception;

    final class AccountUserTests extends TestCase {

        private $params;
        private $tokenParams;

        public function setUp(): void {
            $this->params = array(
                "url" => "http://services.test.sw.com.mx",
                "urlApi" => "http://api.test.sw.com.mx",
                "user" => getenv('SDKTEST_USER'),
                "password" => getenv('SDKTEST_PASSWORD')
            );

            $this->tokenParams = array(
                "urlApi" => "http://api.test.sw.com.mx",
                "token" => getenv('SDKTEST_TOKEN')
            );
        }

        public function testCreateUserSuccess(){
            $message = "AU1001Usuario ya existe.";
            $data = array(
                'Email' => "pavidonavido3@gmail.com",
                'Password' => "galloDeOro13#",
                'Name' => "Valentin Nuño",
                'RFC' => "XIA190128J61",
                'Profile' => 3,
                'Stamps' => 1,
                'Unlimited' => false,
                'Active' => true
            );
            $accountUser = AccountUserService::Set($this->params);
            $result = $accountUser::CreateUser($data);
            if ($result->status === 'success') {
                $this->assertTrue(!empty($result->data), "Data no debe venir vacia");
            } elseif ($result->status === 'error') {
                $this->assertTrue(isset($result->message), "AU1001Usuario ya existe.");
            } else {
                $this->fail("Unexpected status: {$result->status}");
            }
        }

        public function testCreateUserSuccessToken(){
            $message = "AU1001Usuario ya existe.";
            $data = array(
                'Email' => "pavidonavido3@gmail.com",
                'Password' => "galloDeOro13#",
                'Name' => "Valentin Nuño",
                'RFC' => "XIA190128J61",
                'Profile' => 3,
                'Stamps' => 1,
                'Unlimited' => false,
                'Active' => true
            );
            $accountUser = AccountUserService::Set($this->tokenParams);
            $result = $accountUser::CreateUser($data);
            if ($result->status === 'success') {
                $this->assertTrue(!empty($result->data), "Data no debe venir vacia");
            } elseif ($result->status === 'error') {
                $this->assertTrue(isset($result->message), "AU1001Usuario ya existe.");
            } else {
                $this->fail("Unexpected status: {$result->status}");
            }
        }

        public function testGetAllUserSuccess(){
            $resultSpect = "success";
            $accountUser = AccountUserService::Set($this->params);
            $result = $accountUser::GetAllUser();
            $this->assertEquals($resultSpect, $result->status);
        }

        public function testGetAllUserSuccessToken(){
            $resultSpect = "success";
            $accountUser = AccountUserService::Set($this->tokenParams);
            $result = $accountUser::GetAllUser();
            $this->assertEquals($resultSpect, $result->status);
        }

        public function testGetAllUserError(){
            $resultSpect = "error";
            $params = array(
                'urlApi'=> 'http://api.test.sw.com.mx',
                'token'=> '1',
            );
            $accountUser = AccountUserService::Set($params);
            $result = $accountUser::GetAllUser();
            $this->assertEquals($resultSpect, $result->status);
        }

        public function testGetUserSuccess(){
            $resultSpect = "success";
            $accountUser = AccountUserService::Set($this->params);
            $result = $accountUser::GetUser();
            var_dump($result);
            $this->assertEquals($resultSpect, $result->status);
        }

        public function testGetUserSuccessToken(){
            $resultSpect = "success";
            $accountUser = AccountUserService::Set($this->tokenParams);
            $result = $accountUser::GetUser();
            $this->assertEquals($resultSpect, $result->status);
        }

        public function testGetUserError(){
            $resultSpect = "error";
            $params = array(
                'urlApi'=> 'http://api.test.sw.com.mx',
                'token'=> "Token"
            );
            $accountUser = AccountUserService::Set($params);
            $result = $accountUser::GetUser();
            $this->assertEquals($resultSpect, $result->status);
        }

        public function testGetUserByIdSuccess(){
            $resultSpect = "success";
            $idUser="eee19973-df42-46ae-a42b-937e5745346e";
            $accountUser = AccountUserService::Set($this->params);
            $result = $accountUser::GetUserById($idUser);
            $this->assertEquals($resultSpect, $result->status);
        }

        public function testGetUserByIdSuccessToken(){
            $resultSpect = "success";
            $idUser="eee19973-df42-46ae-a42b-937e5745346e";
            $accountUser = AccountUserService::Set($this->tokenParams);
            $result = $accountUser::GetUserById($idUser);
            $this->assertEquals($resultSpect, $result->status);
        }

        public function testGetUserByIdError(){
            $resultSpect = "error";
            $message = "No se encuentra registro de usuario";
            $idUser="6a09aafd-ec66-4578-a000-d67a9a17020b";
            $accountUser = AccountUserService::Set($this->tokenParams);
            $result = $accountUser::GetUserById($idUser);
            $this->assertEquals($resultSpect, $result->status);
            $this->assertEquals($message, $result->message);
        }

        public function testDeleteUserSuccess(){
            $message = "No se encuentra registro de usuario";
            $idUser="09c3d776-e776-4e8c-91a4-00566ae237ee";
            $accountUser = AccountUserService::Set($this->tokenParams);
            $result = $accountUser::DeleteUser($idUser);
            $this->assertTrue($result->status === 'success' || $result->status === 'error');
            $this->assertTrue($result->message === $message || $result->message == null);
        }

        public function testUpdateUserSuccess(){
            $resultSpect = "success";
            $message = "Actualizado exitosamente";
            $idUser="4ee2d8af-a663-45c0-8128-7f0b7b153c7d";
            $data = array(
                'RFC' => "XAXX010101000",
                'Name' => "Nombre Usuario Prueba",
                'Unlimited' => false
            );
            $accountUser = AccountUserService::Set($this->params);
            $result = $accountUser::UpdateUser($idUser, $data);
            var_dump($result);
            $this->assertEquals($resultSpect, $result->status);
            $this->assertEquals($message, $result->data);
            var_dump($result);
        }
         
    }
?>