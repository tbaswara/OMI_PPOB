<?php

class ReportController extends BaseController
{
    protected $trxLogModel;
    
    public function __construct(TransactionLog $trxLogModel)
    {
        $this->trxLogModel = $trxLogModel;
    }
    
    public function ajaxGetMonthlyReport()
    {
        $month = Input::get('month');
        $year = Input::get('year');
        $ppid = Auth::user()->pp_id;

        $trxLog = $this->trxLogModel
                ->select(DB::raw('DATE_FORMAT(date_created, "%d-%m-%Y") AS date'),
                        DB::raw('SUM(total_bulan) AS total_bulan'),
                        DB::raw('SUM(total_rekening) AS total_rekening'),
                        DB::raw('SUM(trans_value) AS total_tagihan'),
                        DB::raw('SUM(admin_value) AS total_admin'),
                        DB::raw('(SUM(trans_value) + SUM(admin_value)) AS total'))
                ->where('trans_type', 2)
                ->where('feedback', '00')
                ->where('pp_id', $ppid)
                ->where(DB::raw('MONTH(date_created)'), $month)
                ->where(DB::raw('YEAR(date_created)'), $year)
                ->groupBy(DB::raw('DATE(date_created)'))
                ->get();
        
        return Response::json($trxLog);
    }
    
    public function ajaxGetDailyReport()
    {
        $date = Input::get('date');
        $mysqlDate = date('Y-m-d', strtotime($date));
        $ppid = Auth::user()->pp_id;
        
        $trxLog = $this->trxLogModel
                ->select('nama_produk', 'nomor_rekening',
                         'nama_pelanggan', 'total_rekening',
                         'total_bulan', 'trans_value', 'admin_value',
                         DB::raw('(trans_value + admin_value) AS total'))
                ->where('pp_id', $ppid)
                ->where('trans_type', 2)
                ->where('feedback', '00')
                ->where(DB::raw('DATE(date_created)'), $mysqlDate)
                ->get();
        
        return Response::json($trxLog);
    }
}
