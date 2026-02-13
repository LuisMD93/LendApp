<?php



namespace Application\ReportUseCases;

use Domain\Repository\IReportRepository;
use Application\Mappers\ReportMapper;

class ChangeLoanStatus {

    private IReportRepository $reportRepository;

    public function __construct(IReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute(int $id): bool {   
        return $this->reportRepository->changeStatus($id) ? true : false;   
    }
}