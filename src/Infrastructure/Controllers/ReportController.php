<?php

namespace Infrastructure\Controllers;

 use Application\DTOs\ReportDto;
 use Application\ReportUseCases\AddReport;
 use Application\ReportUseCases\ListReport;
 use Application\ReportUseCases\SearchByIdReport;
 use Application\ReportUseCases\DeleteReport;
 use Application\ReportUseCases\UpdateReport;
 use Application\ReportUseCases\ChangeLoanStatus;
 use Shared\Helpers\Response;
 use Shared\Mapping\ReportMapper;
 use Shared\Helpers\Constants\Constans;
 use Shared\Helpers\Validations\ReportValidation;

class ReportController{


    private $changeLoanStatus;
    private $addReport;
    private $updateReport;
    private $deleteReport;
    private $listReport;

    // Inyección de dependencia por constructor
    public function __construct(AddReport $addReport, ListReport $listReport/*,SearchByIdReport $searchByPhoneUser*/,DeleteReport $deleteReport ,UpdateReport $updateReport,ChangeLoanStatus $changeLoanStatus) {
        $this->addReport = $addReport;
        $this->changeLoanStatus = $changeLoanStatus;
        $this->updateReport = $updateReport;
        $this->deleteReport = $deleteReport;
        $this->listReport = $listReport;
    }


    function save(ReportDto $reportDto) {
        
        $data = ReportValidation::validateRequiredFields(ReportMapper::toArray($reportDto),Constans::REPORT_FIELDS);
       
        if (!empty($data)) {
            return Response::sendResponse($data, 422);
        }
  
        $response = $this->addReport->execute($reportDto);

        if ($response) {
            return Response::success($response,"Data added to the system");
        }
        return Response::error($response,"The report was not added to the system.",409);
    }

    function show() {
        Response::sendResponse($this->listReport->execute());     
    }


    // // function getAuth(string $name, string $pass) {
    // //     Response::sendResponse($this->listUserAndRole->execute($name,$pass));     
    // // }

    function changeStatus(int $id) {  

        $result = $this->changeLoanStatus->execute($id);
        if($result){
          return Response::success($result,"debt paid successfully");
        }
          return Response::error($result,"Unprocessed debt. Unpaid, perhaps the $id does not exist.",409);

    }

    function update(ReportDto $reportDto){

      $data = ReportValidation::validateRequiredFields(ReportMapper::toArray($reportDto),Constans::REPORT_FIELDS);
       
        if (!empty($data)) {
            return Response::sendResponse($data, 422);
        }
 
         $response = $this->updateReport->execute($reportDto);

         if ($response) {
             return Response::success($response, "data updated correctly");
         }
         return Response::error($response,"User not updated from the system, verify the ID -> ".$reportDto->getId(),409);
  
    }

    function delete(int $id){

       $result = $this->deleteReport->execute($id);
       if($result){
          return Response::success($result,"Report with ID ".$id." deleted from the system.");
       }
          return Response::error($result,"Report not deleted from the system, verify the ID -> ".$id." or that its status is paid",409);
    }


}