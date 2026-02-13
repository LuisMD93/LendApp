<?php 

namespace Domain\Repository;

use Application\DTOs\ReportDto;
use Domain\Models\Report;

interface IReportRepository {

        function createReport(Report $report) : bool;
        function getAllReport(): array;
        function validatePaymentStatus(int $Id): bool;
        function deleteReportById(int $Id) : bool;
        function changeStatus(int $idReport ) : bool;
        function updateReport(Report $report) : bool;
        function existsReport(int $idReport ) : bool;
        function getReportById(int $idReport) : bool;

}