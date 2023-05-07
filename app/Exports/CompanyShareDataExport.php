<?php

namespace App\Exports;

use App\Models\CompanyShareData;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;



class CompanyShareDataExport implements FromView, WithHeadings
{
    protected $companyId;

    public function __construct($companyId)
    {
        $this->companyId = $companyId;
    }

    public function view(): View
    {
        $companyShareData = CompanyShareData::where('company_id', $this->companyId)
            ->select('company_id', 'company_name', 'percentage', 'no_shares', 'regnumber', 'stock_year', 'stock_year_span')
            ->get();

        return view('exports.company_share_data', [
            'companyShareData' => $companyShareData
        ]);
    }

    public function headings(): array
    {
        return ['CompanyId', 'Company', 'Percentage', 'NoShares', 'Regnumber', 'StockYear', 'StockYearSpan'];
    }

    public function store($disk, $path, $shouldPrependTimestamp = false)
    {
        $writer = $this->getWriter();

        $filePath = $this->getDisk()->putFileAs(
            $path,
            $this,
            ($shouldPrependTimestamp ? time() . '-' : '') . $this->fileName
        );

        $this->writer = null;

        return $filePath;
    }

}