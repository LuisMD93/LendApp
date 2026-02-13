<?php

namespace Application\ReportUseCases;

use Domain\Repository\IReportRepository;

class DeleteReport {

    private IReportRepository $reportRepository;

    public function __construct(IReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute(int $id): bool {
        
        if ($this->reportRepository->validatePaymentStatus($id)) {
              $response = $this->reportRepository->deleteReportById($id);
              return $response;  
        }
        return false;
        
    }
}