<?php

class DepositController extends BaseController
{
    const NERACA_DEBET_CODE = 2;
    const NERACE_CREDIT_CODE = 1;
    
    protected $neracaModel;
    
    public function __construct(Neraca $neracaModel)
    {
        $this->neracaModel = $neracaModel;
    }
    
    public function ajaxGetDepositHistory()
    {
        $outletId = Auth::user()->pp_id;
        $month = Input::get('month');
        $year = Input::get('year');
        
        $neraca = $this->neracaModel
                ->select('date_created', 
                        'opening_balance', 
                        'debet_credit',
                        DB::raw('SUM(balance_change) as balance_change'))
                ->where('outlet_id', $outletId)
                ->where(DB::raw('MONTH(date_created)'), $month)
                ->where(DB::raw('YEAR(date_created)'), $year)
                ->groupBy(DB::raw('DATE(date_created)'))
                ->groupBy('debet_credit')
                ->get();
        
        $result = array();
        foreach ($neraca as $row)
        {   
            $date = date_create($row['date_created']);
            $dateString = date_format($date, 'd-m-Y');
            
            if(!array_key_exists($dateString, $result))
            {
                $result[$dateString] = array();
                $result[$dateString]['opening'] = $row['opening_balance'];
                $result[$dateString]['debet'] = 0;
                $result[$dateString]['credit'] = 0;
                $result[$dateString]['saldo'] = $row['opening_balance'];
            }
            
            if($row['debet_credit'] == self::NERACA_DEBET_CODE)
            {
                $result[$dateString]['debet'] = $row['balance_change'];
                $result[$dateString]['saldo'] -= $row['balance_change'];
            }
            else if($row['debet_credit'] == self::NERACE_CREDIT_CODE)
            {
                $result[$dateString]['credit'] = $row['balance_change'];
                $result[$dateString]['saldo'] += $row['balance_change'];
            }
        }
        
        return Response::json($result);
    }
}
