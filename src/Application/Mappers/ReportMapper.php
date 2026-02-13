<?php

namespace Application\Mappers; 

use Application\DTOs\ReportDto;
use Domain\Models\Report;
use DateTime;

class ReportMapper {


    public static function toEntity(ReportDto $dto): Report {
        return new Report(
            $dto->id,
            $dto->loan_location,
            $dto->productName,
            $dto->amount,
            $dto->description,
            $dto->lendStatus,
            $dto->id_user,
            $dto->creationDate,
            $dto->modificationDate

        );
    }

    public static function toDto(Report $entity): ReportDto {
        return new ReportDto(
            $entity->getId(),
            $entity->getLoan_location(),
            $entity->getProducName(),
            $entity->getAmount(),
            $entity->getDescription(),
            $entity->getLendStatus(),
            $entity->getIdUser(),
            $entity->getCreationDate(),
            $entity->getModificationDate()
           );
    }

    public static function fromArrayEntity(array $reports) {
        $reportArray = [];
        foreach ($reports as $report) {
          $reportArray[] =  new Report(
                $report['id'],  
                $report['loan_location'],
                $report['product_name'],
                $report['amount'],
                $report['description'],
                $report['lendStatus'],
                $report['id_user'],
                new DateTime($report['creationDate']), 
                new DateTime($report['modificationDate']),


            );
        }
        return $reportArray;
    }

    public static function fromArrayDto(array $reports): array {
        $reportArrayDto = [];
        foreach ($reports as $reportDto) {      
          $reportArrayDto[] =  new ReportDto(
                $reportDto->getId(),
                $reportDto->getLoan_location(),
                $reportDto->getProducName(),
                $reportDto->getAmount(),
                $reportDto->getDescription(),
                $reportDto->getLendStatus(),
                $reportDto->getIdUser(),  
                $reportDto->getCreationDate(),
                $reportDto->getModificationDate()
 
            );
          
        }
        return $reportArrayDto; 
    }
}


