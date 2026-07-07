<?php

namespace Shared\Mapping;

use Application\Dtos\ReportDto;
use Application\Dtos\UserSummaryDto;

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
                'id_user' => $report->getUser()->getId()
                ];
                
    }

    
    public static function fromArray(array $data) {

        $user = new UserSummaryDto($data["userData"]['id'],$data["userData"]['username']);
        return new ReportDto(
                $data["id"] ?? 0,
                $data["location"],
                $data["name"],
                $data["amount"],    
                $data["description"],    
                $data["lendStatus"] , 
                $user,
                new DateTime(),
                new DateTime()  
        );
    }

   
}





