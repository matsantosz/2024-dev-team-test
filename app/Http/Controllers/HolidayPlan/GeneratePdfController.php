<?php

declare(strict_types=1);

namespace App\Http\Controllers\HolidayPlan;

use App\Data\HolidayPlanData;
use App\Models\HolidayPlan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

final class GeneratePdfController
{
    public function __invoke(HolidayPlan $holidayPlan): Response
    {
        $data = HolidayPlanData::from($holidayPlan);

        $pdf = Pdf::loadView('pdf.holiday-plan', $data->toArray());

        return $pdf->download("$data->title.pdf");
    }
}
