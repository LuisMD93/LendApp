<?php

namespace Application\ReportUseCases;

use Application\DTOs\ReportDto;
use Domain\Repository\IReportRepository;
use Application\Mappers\ReportMapper;

class UpdateReport {

    private IReportRepository $reportRepository;

    public function __construct(IReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute(ReportDto $reportDto): bool {
        
             if($this->reportRepository->existsReport($reportDto->getId())){
                $reportEntity = ReportMapper::toEntity($reportDto);
                $response = $this->reportRepository->updateReport($reportEntity);
                return $response;
             }
           
            return false;  
        
    }
}