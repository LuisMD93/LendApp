<?php

namespace Shared\Mapping;

use Application\DTOs\ReportDto;

use DateTime;

class ReportMapper {

    public static function toArray(ReportDto $report) {
      
        return [   
                'id' => $report->getId(),
                'location' => $report->getLoan_location(),
                'name' => $report->getProducName(),
                'amount' => $report->getAmount(),
                'description' => $report->getDescription(),
  
                'lendStatus' => $report->getLendStatus(),
                'id_user' => $report->getIdUser()   
        ];
    }

    
    public static function fromArray(array $data) {

        return new ReportDto(
                $data["id"] ?? 0,
                $data["location"],
                $data["name"],
                $data["amount"],    
                $data["description"],    
                $data["lendStatus"] , 
                $data["id_user"],  
                new DateTime(),
                new DateTime()  
        );
    }

   
}





