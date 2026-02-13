<?php

namespace Application\ReportUseCases;

use Domain\Repository\IReportRepository;
use Application\Mappers\ReportMapper;

class ListReport {

    private IReportRepository $reportRepository;

    public function __construct(IReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute(): array {
        
            $report = $this->reportRepository->getAllReport();
            #echo '<pre>';var_dump($report); echo '</pre>';die;
            $dataEntity = ReportMapper::fromArrayEntity($report);
            $dataDto = ReportMapper::fromArrayDto($dataEntity);
            return $dataDto;
        
    }
}