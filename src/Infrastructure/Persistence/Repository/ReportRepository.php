<?php


namespace Infrastructure\Persistence\Repository;

use Domain\Models\Report;
use Domain\Repository\IReportRepository;
use Infrastructure\Persistence\Doctrine\Connection;
use \PDO;
use \Exception;
use \PDOException;

#CORREGIR EL FRONTEND FLUTTER NO ALCENA POR QUE ESTA COMENTADO Y ADEMAS CORREGIR LA FECHA Y HORA LAMACENADA EN LA BD DESDE ELL BACKEND
class ReportRepository implements IReportRepository  {

    private $connection;

    //Constructor con inyección de la dependencia (el objeto de conexión)
    public function __construct(Connection $db) {
        $db = Connection::getInstance();
        $this->connection = $db->getConnection();
    }

    function createReport(Report $report): bool {

        $response = false;
        #echo '<pre>'; print_r($report); echo '</pre>';die;
        try {
            $this->connection->beginTransaction();

            $this->connection->exec("SET search_path TO lend_app_introduced");

            $sql = "CALL add_report(
                :p_location_name_,
                :p_product_Name_,
                :p_amount_,
                :p_description_,
                :p_lend_status_,
                :p_id_user_,
                :p_creation_date,
                :p_modification_date
            )";

                $stmt = $this->connection->prepare($sql);

                $loan_location = $report->getLoan_location();
                $productName = $report->getProducName();
                $amount = $report->getAmount();
                $lendStatus = $report->getLendStatus() ? true : false;
                $description = $report->getDescription();
                $id_user = $report->getIdUser();

                $creationDate = $report->getCreationDate()->format('Y-m-d H:i:s');
                $modificationDate = $report->getModificationDate()->format('Y-m-d H:i:s');
                // echo json_encode([
                //     'loan_location' => $loan_location,
                //     'productName' => $productName,
                //     'amount' => $amount,
                //     'lendStatus' => $lendStatus,
                //     'description' => $description,
                //     'id_user' => $id_user,
                //     'creationDate' => $creationDate,
                //     'modificationDate' => $modificationDate
                // ], JSON_PRETTY_PRINT);
              

                $stmt->bindParam(':p_location_name_', $loan_location, PDO::PARAM_STR);
                $stmt->bindParam(':p_product_Name_', $productName, PDO::PARAM_STR);
                $stmt->bindParam(':p_amount_', $amount, PDO::PARAM_INT);
                $stmt->bindParam(':p_description_', $description, PDO::PARAM_STR);
                $stmt->bindParam(':p_lend_status_', $lendStatus, PDO::PARAM_BOOL);
                $stmt->bindParam(':p_id_user_', $id_user, PDO::PARAM_INT);

                $stmt->bindParam(':p_creation_date', $creationDate, PDO::PARAM_STR);
                $stmt->bindParam(':p_modification_date', $modificationDate, PDO::PARAM_STR);

                $stmt->execute();
                var_dump($stmt->errorInfo());

                $this->connection->commit();
                $response = true;

            } catch (Exception $e) {
                $this->connection->rollBack();
                error_log("Error createReport: " . $e->getMessage());
            } finally {
                $this->connection = null;
            }

        return $response;
    }
  
       
    function getAllReport(): array {

        $sql = "SELECT * FROM get_all_reports()";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function deleteReportById(int $Id): bool {
        $response = false;

        try {
            $this->connection->beginTransaction();

            $sql = "CALL delete_report(:_id)";
            $stmt = $this->connection->prepare($sql);

            $stmt->bindParam(':_id', $Id, PDO::PARAM_INT);
            $stmt->execute();

            $this->connection->commit();
            $response = true;

        } catch (PDOException $e) {
            if ($this->connection->inTransaction()) {
                $this->connection->rollBack();
            }
            error_log("Error deleteReportById: " . $e->getMessage());
            $response = false;

        } finally {
            $this->connection = null;
        }

        return $response;
    }

    function existsReport(int $idReport): bool {
        try {
            $sql = "SELECT exists_report(:_idReport) as exists";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':_idReport', $idReport, PDO::PARAM_INT);

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return (bool)$result['exists'];

        } catch (Exception $e) {
            error_log("Error existsReport: " . $e->getMessage());
            return false;
        } finally {
            $this->connection = null;
        }
}

    function getReportById(int $report) : bool {
        return true;
    }
    
    function updateReport(Report $report): bool {
        $response = false;

        try {
            $this->connection->beginTransaction();

            $sql = "CALL update_report_by_id(:p_id, :p_location, :p_name, :p_amount, :p_description)";
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

            // ✔ En PostgreSQL: si no hay excepción = éxito
            $this->connection->commit();
            $response = true;

        } catch (PDOException $e) {
            if ($this->connection->inTransaction()) {
                $this->connection->rollBack();
            }
            error_log("Error updateReport: " . $e->getMessage());
            $response = false;

        } finally {
            $this->connection = null;
        }

        return $response;
    }
 
    function changeStatus(int $idReport): bool {
        try {
            // Llamamos al procedure
            $sql = "CALL change_to_paid_status(:id)";
            $stmt = $this->connection->prepare($sql);

            $stmt->bindParam(':id', $idReport, PDO::PARAM_INT);
            $stmt->execute();

            // Si no lanza excepción = éxito
            return true;

        } catch (Exception $e) {
            error_log("Error changeStatus: " . $e->getMessage());
            return false;
        }
    }

    function validatePaymentStatus(int $Id) : bool {

        try {
            $sql = "SELECT PaymentStatus(:p_id) AS result";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':p_id', $Id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['result'] ?? false;
        } catch (Exception $e) {
            return false;
        }
    }
}