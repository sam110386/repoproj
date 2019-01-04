<?php

namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Models\Institute;
use App\Helpers\CommonMethod;
class ReportExpoter extends AbstractExporter
{
    /**
     * {@inheritdoc}
     */
    public function export()
    {   
        
        $filename = 'Report.csv';

        $headers = [
            'Content-Encoding'    => 'UTF-8',
            'Content-Type'        => 'text/csv;charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        response()->stream(function () {
            $handle = fopen('php://output', 'w');

            $titles = [];

            $this->chunk(function ($records) use ($handle, &$titles) {
                if (empty($titles)) {
                    $titles = $this->getHeaderRowFromRecords($records);

                    // Add CSV headers
                    fputcsv($handle, $titles);
                }

                foreach ($records as $record) {
                    fputcsv($handle, $this->getFormattedRecord($record));
                }
            });

            // Close the output stream
            fclose($handle);
        }, 200, $headers)->send();

        exit;
    }

    /**
     * @param Collection $records
     *
     * @return array
     */
    public function getHeaderRowFromRecords(Collection $records): array
    {
        return array("Id","Institute","Report_category","Submission_period","Report_year","Total_capital","Total_assest","Total_liability","Loan_advance","Customer_deposits","Profit_before_tax","Return_average_assets","Return_equity","Created_at","Updated_at");
    }

    /**
     * @param Model $record
     *
     * @return array
     */
    public function getFormattedRecord(Model $record)
    {   $tempData=$record->getAttributes();
        $instituteName=Institute::find($tempData['institute_id'])->name;
        if($tempData['report_category']=='Monthly'){
            $Submission_period=CommonMethod::getMonthName($tempData['submission_period']);
        }elseif ($tempData['report_category']=='Quaterly') {
            $Submission_period=CommonMethod::getQuarterName($tempData['submission_quater']);
        }else{
            $Submission_period='';
        }   
            
        return array($tempData['id'],$instituteName,$tempData['report_category'],$Submission_period,$tempData['report_year'],$tempData['total_capital'],$tempData['total_assest'],$tempData['total_liability'],$tempData['loan_advance'],$tempData['customer_deposits'],$tempData['profit_before_tax'],$tempData['return_average_assets'],$tempData['return_equity'],$tempData['created_at'],$tempData['updated_at']);
        //return array_dot($record->getAttributes());
    }
}