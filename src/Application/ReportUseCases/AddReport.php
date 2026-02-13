<?php

namespace Application\ReportUseCases;

use Application\DTOs\ReportDto;
use Domain\Repository\IReportRepository;
use Application\Mappers\ReportMapper;

class AddReport {

    private  IReportRepository $reportRepository;

    public function __construct(IReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute(ReportDto $reportDto): bool {

            $reportEntity = ReportMapper::toEntity($reportDto);
            $response = $this->reportRepository->createReport($reportEntity);
            return $response;  
        
    }
}