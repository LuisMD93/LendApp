<?php

namespace Infrastructure\Persistence\Repository;

use Domain\Repository\IUserRepository;
use Infrastructure\Persistence\Doctrine\Connection;
use Domain\Models\User;
use \PDO;
use \Exception;

class UsersRepository implements IUserRepository {


    private $connection;

    //Constructor con inyección de la dependencia (el objeto de conexión)
    public function __construct(Connection $db) {
        $db = Connection::getInstance();
        $this->connection = $db->getConnection();
    }
    

    /*
    function createUser(User $user) : bool{
    
        try{

        $response = false;
           
            $this->connection->beginTransaction(); 
            
            $sql = "call add_user(:p_user_name_,:p_email_,:p_password_,:p_api_token_,:p_phone_,:p_rol_user)";
            $stmt = $this->connection->prepare($sql);
        
                $name = $user->getUsername();
                $email = $user->getEmail();
                $pass = $user->getPassword();
                $apiToken = $user->getApiToken();
                $phon_cell = $user->getPhone();
                $rol_user = $user->getRoleEnum();
                      
                $stmt->bindParam(':p_user_name_', $name, PDO::PARAM_STR);
                $stmt->bindParam(':p_email_', $email, PDO::PARAM_STR);
                $stmt->bindParam(':p_password_', $pass, PDO::PARAM_STR);
                $stmt->bindParam(':p_api_token_', $apiToken, PDO::PARAM_STR);
                $stmt->bindParam(':p_phone_', $phon_cell, PDO::PARAM_STR);
                $stmt->bindParam(':p_rol_user', $rol_user, PDO::PARAM_STR);
                
        
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->connection->commit();
                $response = true;
            } else {
                $this->connection->rollBack();
            }
         
            return $response;
            
        } catch (Exception $e) {
            $this->connection->rollBack();
            echo "Error: " . $e->getMessage();
        } finally {
            return $response;
            $this->connection = null;
        }

    }     
    */
    function createUser(User $user): bool {
    try {
        $this->connection->beginTransaction();

        // Para PROCEDURES en Postgres se usa CALL
        $sql = "CALL add_user(:p_user_name_, :p_email_, :p_password_, :p_api_token_, :p_phone_,:p_rol_user_)";
        $stmt = $this->connection->prepare($sql);

        $stmt->bindValue(':p_user_name_', $user->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':p_email_', $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':p_password_', $user->getPassword(), PDO::PARAM_STR);
        $stmt->bindValue(':p_api_token_', $user->getApiToken(), PDO::PARAM_STR);
        $stmt->bindValue(':p_phone_', $user->getPhone(), PDO::PARAM_STR);
        $stmt->bindValue(':p_rol_user_', $user->getRoleEnum(), PDO::PARAM_STR);

        $result = $stmt->execute();

        // En un PROCEDURE, si no hubo excepción, asumimos éxito.
        // commit() confirmará la inserción en Postgres.
        $this->connection->commit();
        return true;

    } catch (Exception $e) {
        if ($this->connection->in_transaction()) {
            $this->connection->rollBack();
        }
        // Registramos el error exacto de Postgres (ej. violación de unicidad de email)
        error_log("Error en add_user (Postgres): " . $e->getMessage());
        return false;
    }
}
    function  findUserById(int $userId) : bool{

        $sql = "CALL search_User_by_Id(:userId)";
        $stmt = $this->connection->prepare($sql);
   
         $stmt->bindParam(':userId',$userId, PDO::PARAM_STR);
         $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC) > 0 ? true: false;     

    }
    /*
    function getAllUsers() : array {

        $sql = "call get_All_Users()";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    */

    function getAllUsers() : array {
        // En Postgres, las funciones que devuelven tablas se consultan con SELECT
        $sql = "SELECT * FROM get_all_users()"; 
    
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    
        // Retornamos los datos como un array asociativo
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

     function updateUser(User $user) : bool {

        try {

            $response = false;
            
            $this->connection->beginTransaction(); // Iniciar una transacción
            
            $sql = "call update_User_by_id(:p_id_, :p_user_name_, :p_password_, :p_email_, :p_token_,:p_phone_)"; 
            $stmt = $this->connection->prepare($sql);    
           
            $id = $user->getId();
            $user_name = $user->getUsername();
            $new_password= $user->getPassword();
            $new_email = $user->getEmail();
            $new_api_token= $user->getApiToken();
            $new_phone = $user->getPhone();

        
            $stmt->bindParam(':p_id_', $id);
            $stmt->bindParam(':p_user_name_', $user_name);
            $stmt->bindParam(':p_password_', $new_password);
            $stmt->bindParam(':p_email_', $new_email);
            $stmt->bindParam(':p_token_', $new_api_token);
            $stmt->bindParam(':p_phone_', $new_phone);
            
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $this->connection->commit();
                $response = true;
            } else {
                $this->connection->rollBack();
            }
             
            return $response;
            
        } catch (Exception $e) {
            $this->connection->rollBack();
            echo "Error: " . $e->getMessage();
        } finally {
            return $response;
            $this->connection = null;
        }

    } 
    /*
    function searchUserByPhone(string $phone) : bool{
        
        $sql = "CALL search_by_phone_User(:p_phone)";
        $stmt = $this->connection->prepare($sql);
   
         $stmt->bindParam(':p_phone',$phone, PDO::PARAM_STR);
         $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC) > 0 ? true: false;
    }
    */

    function searchUserByPhone(string $phone) : bool {
        // 1. En Postgres usamos SELECT para funciones que devuelven resultados
        $sql = "SELECT id FROM search_by_phone_user(:p_phone)";
    
         $stmt = $this->connection->prepare($sql);
         $stmt->bindParam(':p_phone', $phone, \PDO::PARAM_STR);
         $stmt->execute();
    
        // 2. fetch() devuelve la fila encontrada o FALSE si no hay nada
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        // Retornamos true si $result es un array (encontró algo), false si es boolean false
        return $result !== false;
    }

    function deleteUserById(int $Id) : bool{

        try{

            $sql="CALL delete_by_id_Users(:id)";
            $stmt = $this->connection->prepare($sql);

            $stmt->bindParam(':id', $Id, PDO::PARAM_INT);

            $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
        } catch(Exception $e) {
            
            return false;
        } finally {
            $this->connection = null;
        }
    }
    /*
    function existsUser(string $email,string $phone) : bool{

        $sql = "CALL exists_user(:p_email,:p_phone)";
        $stmt = $this->connection->prepare($sql);
   
         $stmt->bindParam(':p_email',$email, PDO::PARAM_STR);         
         $stmt->bindParam(':p_phone',$phone, PDO::PARAM_STR);
         $stmt->execute();
         return $stmt->fetch(PDO::FETCH_ASSOC) > 0 ? true: false;
    
    }
    */
 
    // function existsUser(string $email, string $phone) : bool {
    //      // 1. Cambiamos CALL por SELECT porque en Postgres es una FUNCTION
    //      $sql = "SELECT email FROM exists_user(:p_email, :p_phone)";
    
    //      $stmt = $this->connection->prepare($sql);
  
    //      $stmt->bindParam(':p_email', $email, PDO::PARAM_STR);         
    //      $stmt->bindParam(':p_phone', $phone, PDO::PARAM_STR);
    
    //      $stmt->execute();

    //      // 2. fetch() devuelve el array de la fila si existe, o FALSE si no hay nada
    //      $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //      // Si $result no es falso, significa que encontró al usuario
    //      return $result !== false;
    // }
    function existsUser(string $email, string $phone) : bool {
    $sql = "
        SELECT EXISTS(
            SELECT 1 
            FROM users 
            WHERE email = :p_email 
              AND phone = :p_phone
        ) AS user_exists
    ";

    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':p_email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':p_phone', $phone, PDO::PARAM_STR);

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['user_exists'] === true || $result['user_exists'] === 't';
}

    /*
    function login(string $user_name,string $phone) : array{

        $sql = "CALL login_user(:p_user_name,:p_phone)";
        $stmt = $this->connection->prepare($sql);
   
         $stmt->bindParam(':p_user_name',$user_name, PDO::PARAM_STR);         
         $stmt->bindParam(':p_phone',$phone, PDO::PARAM_STR);
         $stmt->execute();  

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: []; // devuelve array vacío si no hay resultado
    
    }
    */

    function login(string $user_name, string $phone): array {

        $sql = "SELECT *
            FROM users
            WHERE username = :p_user_name
            AND REPLACE(phone, '+57 ', '') = :p_phone
            LIMIT 1";


        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(':p_user_name', $user_name, PDO::PARAM_STR);
        $stmt->bindParam(':p_phone', $phone, PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
     
        return $result ?: []; // devuelve array vacío si no hay resultado
    }


}