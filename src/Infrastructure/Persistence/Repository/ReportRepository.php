<?php


namespace Infrastructure\Persistence\Repository;

use Domain\Models\Report;
use Domain\Repository\IReportRepository;
use Infrastructure\Persistence\Doctrine\Connection;
use \PDO;
use \Exception;


class ReportRepository implements IReportRepository  {

    private $connection;

    //Constructor con inyección de la dependencia (el objeto de conexión)
    public function __construct(Connection $db) {
        $db = Connection::getInstance();
        $this->connection = $db->getConnection();
    }
    
    function createReport(Report $report) : bool{

        try{

            $response = false;
            
                $this->connection->beginTransaction(); 
                
                $sql = "call add_report(:p_location_name_,:p_product_Name_,:p_amount_,:p_description_,:p_lend_status_,:p_id_user_)";
                $stmt = $this->connection->prepare($sql);
            
        
                    $loan_location = $report->getLoan_location(); 
                    $productName = $report->getProducName();
                    $amount = $report->getAmount();
                    $lendStatus = $report->getLendStatus();
                    $description = $report->getDescription();
                    $id_user = $report->getIdUser();
                
                    $stmt->bindParam(':p_location_name_', $loan_location, PDO::PARAM_STR);
                    $stmt->bindParam(':p_product_Name_', $productName, PDO::PARAM_STR);
                    $stmt->bindParam(':p_amount_', $amount, PDO::PARAM_INT);
                    $stmt->bindParam(':p_description_', $description, PDO::PARAM_STR);
                    $stmt->bindParam(':p_lend_status_', $lendStatus, PDO::PARAM_BOOL);  
                    $stmt->bindParam(':p_id_user_', $id_user, PDO::PARAM_INT);
                    
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
  
       
    function getAllReport(): array {

        $sql = "call get_all_reports()";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function deleteReportById(int $Id) : bool {
    
     try{

            $sql="CALL delete_report(:_id)";
            $stmt = $this->connection->prepare($sql);

            $stmt->bindParam(':_id', $Id, PDO::PARAM_INT);

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
            return true;
    }

    function existsReport(int $idReport ) : bool {

        try{
            $sql = "CALL exists_report(:_idReport)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':_idReport', $idReport, PDO::PARAM_INT);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                $this->connection = null;
                return false;
                
            }
        } catch(Exception $e) {
            
            return false;
        } finally {
           
        }
            return true;
    }

    function getReportById(int $report) : bool {
        return true;
    }
    
    function updateReport(Report $report) :bool {

        try {
            
            $response = false;
            $this->connection->beginTransaction(); // Iniciar una transacción
            
            $sql = "call update_Report_by_id(:p_id, :p_location,:p_name ,:p_amount, :p_description)"; 
            $stmt = $this->connection->prepare($sql);    
           
            $id = $report->getId();
            $new_location = $report->getLoan_location();
            $new_product_name = $report->getProducName();
            $new_amount = $report->getAmount();
            $new_description = $report->getDescription();
 
            $stmt->bindParam(':p_id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':p_location', $new_location, PDO::PARAM_STR);
            $stmt->bindParam(':p_name', $new_product_name, PDO::PARAM_STR);
            $stmt->bindParam(':p_amount', $new_amount, PDO::PARAM_INT);
            $stmt->bindParam(':p_description', $new_description, PDO::PARAM_STR);
            
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
 
    function changeStatus(int $idReport) : bool {
        try {

            $sql = "CALL ChangeToPaidStatus(:id, @affected)";
            $stmt = $this->connection->prepare($sql);

            $stmt->bindParam(':id', $idReport, PDO::PARAM_INT);
            $stmt->execute();

            $result = $this->connection->query("SELECT @affected AS affected")->fetch(PDO::FETCH_ASSOC);
            return $result['affected'] > 0;

        } catch (Exception $e) {
            return false;
        }
    }

    function validatePaymentStatus(int $Id) : bool {

        try {
            $sql = "CALL PaymentStatus(:p_id)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':p_id', $Id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result !== false;
        } catch (Exception $e) {
            return false;
        }
    }
}