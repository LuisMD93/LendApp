<?php

namespace Application\Mappers; 

use Application\Dtos\ReportDto;
use Application\Dtos\UserDto;
use Domain\Models\Report;
use Domain\Models\User;
use DateTime;

class ReportMapper {


    public static function toEntity(ReportDto $dto): Report {
        $user = new User(
            $dto->user->getId(),
            $dto->user->getUsername()
        );

        return new Report(
            $dto->id,
            $dto->loan_location,
            $dto->productName,
            $dto->amount,
            $dto->description,
            $dto->lendStatus,
            $user,
            $dto->creationDate,
            $dto->modificationDate
        );
    }

    public static function toDto(Report $entity): ReportDto {
        $userDto = new UserDto(
            $entity->getUser()->getId(),
            $entity->getUser()->getUsername()
        );

        return new ReportDto(
            $entity->getId(),
            $entity->getLoan_Location(),
            $entity->getProducName(),
            $entity->getAmount(),
            $entity->getDescription(),
            $entity->getLendStatus(),
            $userDto,
            $entity->getCreationDate(),
            $entity->getModificationDate()
        );
    }

    public static function fromArrayEntity(array $reports) {
        $reportArray = [];
        foreach ($reports as $report) {

         $user = new User(
            $report['id_user'],
            $report['username']
          );

          $reportArray[] =  new Report(
                $report['id'],  
                $report['loan_location'],
                $report['product_name'],
                $report['amount'],
                $report['description'],
                $report['lend_status'],
                $user,
                new DateTime($report['creation_date']), 
                new DateTime($report['modification_date']),


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
                $reportDto->getUser(),  
                $reportDto->getCreationDate(),
                $reportDto->getModificationDate()
 
            );
          
        }
        return $reportArrayDto; 
    }
}


