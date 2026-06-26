<?php

namespace Application\ReportUseCases;

use Application\Dtos\ReportDto;
use Domain\Repository\IReportRepository;
use Application\Mappers\ReportMapper;
use DateTime;

class AddReport {

    private  IReportRepository $reportRepository;

    public function __construct(IReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute(ReportDto $reportDto): bool {

            $reportEntity = ReportMapper::toEntity($reportDto);
            $reportEntity->setCreationDate(new DateTime());
            $reportEntity->setModificationDate(new DateTime());
            $response = $this->reportRepository->createReport($reportEntity);
            return $response;  
        
    }
}