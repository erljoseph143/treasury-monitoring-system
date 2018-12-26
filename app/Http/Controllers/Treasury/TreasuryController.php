<?php

namespace App\Http\Controllers\Treasury;

use App\BankAccount;
use App\Cashlog;
use App\CashLogBook;
use App\CashPullOut;
use App\Checks;
use App\CPOLedger;

use App\Denomination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TreasuryController extends Controller
{
    //
	public function forDeposit(Request $request)
	{
		$login_user = $request->user('api');
		$buName     = $login_user->businessunit->bname;
		$month      = Denomination::select(DB::raw('date_shrt'))
			          ->where('emp_bu',$buName)
			          ->where('dep_status','')
					  ->groupBy(DB::raw('MONTH(date_shrt)'))
					  ->orderBy('date_shrt', 'DESC')
					  ->get();
		
		
//		$month = CashLogBook::select(DB::raw('sales_date'))
//			->where('company', $login_user->company_id)
//			->where('bu_unit', $login_user->bunitid)
//			->where('deposit_date', null)
//			->groupBy(DB::raw('MONTH(sales_date)'))
//			->orderBy('sales_date', 'DESC')
//			->get();
		return $month;
	}
	
	public function dailyDep(Request $request,$date)
	{
		$login_user = $request->user('api');
		$buName     = $login_user->businessunit->bname;
		$month      = date("m", strtotime($date));
		$year       = date("Y", strtotime($date));
		
		$daily      = Denomination::whereMonth('date_shrt', $month)
					->whereYear('date_shrt', $year)
					->where('emp_bu',$buName)
					->where('dep_status','')
					->orderBy('date_shrt', 'DESC')
					->distinct()->get(['date_shrt']);
		
//		$daily      = CashLogBook::whereMonth('sales_date', $month)
//					->whereYear('sales_date', $year)
//					->where('deposit_date', null)
//					->where('company', $login_user->company_id)
//					->where('bu_unit', $login_user->bunitid)
//					->orderBy('sales_date', 'DESC')
//					->distinct()->get(['sales_date']);
		return $daily;
	}
	
	public function viewDep(Request $request,$date)
	{
		$login_user  = $request->user('api');
		session()->forget('check_data_receive');
		$month       = session('month');
		//Cash LOG Book Posted by liquidation
		
		$adjs        = Array();
		$dueCheck    = Array();
		$totalDue    = 0;
		$totalPDC    = 0;
		$checktype   = Array();
		$checkClass  = Array();
		
		$totalChecks = 0;
		
		$cpoledger   = CPOLedger::where('paid_date', $date)
						->where('company', $login_user->company_id)
						->where('bu_unit', $login_user->bunitid);
		$cpolg       = $cpoledger->get();
		$cpolgsum    = $cpoledger->sum('check_amount');
		
		$adj3        = Checks::where('check_received','<=',$date)->where('date_deposit',null)->where('businessunit_id',$login_user->bunitid)->get();
		//session(['check_data_receive'=>$adj3]);
		session()->push('check_data_receive', $adj3);
		foreach($adj3->unique('check_class') as $key => $checkCl)
		{
			$totalCl      = $adj3->where('check_class',$checkCl->check_class)->sum('check_amount');
			$checkClass[] = (object)['check_class'=>$checkCl->check_class,'check_from'=>'ATP','check_amt_total'=>round($totalCl,2)];
		}
		
		foreach ($adj3 as $ck)
		{
			$checktype[] = $ck;
			$d1          = strtotime($date);
			$d2          = strtotime($ck->check_date);
			if ($d2 > $d1)
			{
				$totalPDC  += $ck->check_amount;
				$adjs[]     = [$ck->check_no, $ck->check_amount];
			}
			elseif ($d2 <= $d1)
			{
				$totalDue   += $ck->check_amount;
				$dueCheck[] = [$ck->check_no, $ck->check_amount];
			}
			$totalChecks += $ck->check_amount;
		}
		
		$allChecks[] = ['Due Checks', round($totalDue+$cpolgsum,2)];
		$allChecks[] = ['PDC', round($totalPDC,2)];
		
		$bankact     = BankAccount::where('company_code', $login_user->company_id)
						->where('buid', $login_user->bunitid)
						->get()
						->pluck('BankAccountList', 'id')
						->all();
		$cpoData     = CashPullOut::where('pull_out_date', $date)
						->where('bu_unit', $login_user->bunitid)
						->where('company', $login_user->company_id)
						->where('approve_by', '!=', '');
		$cposum      = $cpoData->sum('amount_edited');
		$cpo         = $cpoData->get();
		
		$cashLog     = CashLogBook::where('sales_date', $date)
						->where('company', $login_user->company_id)
						->where('bu_unit', $login_user->bunitid)
						->where('status_clerk', 'posted')
						->orderBy('cash_id', 'asc')
						->get();
		
		foreach($cashLog as $key => $cs)
		{
			$cs->cashLog->description;
		}
		$csLog       = Cashlog::all();
		foreach($csLog->where('cash_status','automatic') as $key => $index)
		{
			unset($csLog[$key]);
			$csKeys = $cashLog->where('cash_id',$index->id);
			if($csKeys->count('id')>0)
			{
				unset($cashLog[$csKeys->keys()[0]]);
			}
		}
		
		foreach($csLog->where('cash_status','manual') as $key => $index)
		{
			$csKeys = $cashLog->where('cash_id',$index->id);
			if($csKeys->count('id')>0)
			{
				unset($csLog[$key]);
			}
		}
		
		//dd($csLog);

		$cashForDep   = round($cashLog->sum('amount_edited'),2);
		$fromCS       = $this->cashLog($request,$date);
		$adjustment   = $this->adjandCPO($cpo, $allChecks);
		$SMTotalCash  = $this->totalCashSM($fromCS,$adjustment);
		$total        = $this->totalCashForDeposit($fromCS,$SMTotalCash);
		$cashForDep   = round($total + $cashForDep,2);


		
		$allLogstotal = round($cashForDep + $cposum + $totalChecks,2);
		
		$allCKtotal   = round($totalChecks+$cpolgsum,2);
		

		return response()->json([$checkClass,$cpolg,$cashForDep,$cashLog,$adjustment,$allCKtotal,$fromCS,$allLogstotal,$SMTotalCash,$csLog]);

	}
	
	public function cashLog($request,$date)
	{
		$login_user  = $request->user('api');
		$buName      = $login_user->businessunit->bname;
		$cashLog     = Cashlog::where('cash_status','automatic')->get();
		$cashArray   = Array();
		$totalCash   = 0;
		foreach($cashLog as $key => $cash)
		{
			$denomination = Denomination::where('emp_dept',$cash->description)
							->where('date_shrt',$date)
							->where('emp_bu',$buName)
							->get();

				$sum1k    = $denomination->sum('1k_q');
				$sum5h    = $denomination->sum('5h_q');
				$sum2h    = $denomination->sum('2h_q');
				$sum1h    = $denomination->sum('1h_q');
				$sum50p   = $denomination->sum('50p_q');
				$sum20p   = $denomination->sum('20p_q');
				$sumCoins = $denomination->sum('coins');
				$denom    = [
								'cs_1k'  => $sum1k  * 1000,
								'cs_5h'  => $sum5h  * 500,
								'cs_2h'  => $sum2h  * 200,
								'cs_1h'  => $sum1h  * 100,
								'cs_50p' => $sum50p * 50,
								'cs_20p' => $sum20p * 20,
								'coins'  => $sumCoins
							];
			if($denomination->count('cs_deno_id')>1)
			{
				$totalCash = 0;
				$totalCash += $this->sumAllDenomination($denom);
			}
			else
			{
				$totalCash = 0;
			}
			
			$cashArray[] = ['cash_log'=>$cash->description,'denom'=> $denom,'totalCash'=>$totalCash,'sales_date'=>$date];
		}
		
		return $cashArray;
	}
	
	public function totalCashSM($data,$adjustment)
	{
		$total = 0;
		foreach(collect($data) as $key => $d)
		{
			if($d['cash_log'] == "SUPERMARKET")
			{
				$total += $d['totalCash'];
				foreach($adjustment as $key2 => $adj)
				{
					if($adj[1]!="Due Checks")
					{
						$total -=$adj[2];
					}
				}
			}
		}
		return round($total,2);
	}
	
	public function totalCashForDeposit($cashArray,$totalSM)
	{
		$totalAllCash = 0;
		foreach($cashArray as $key => $cash)
		{
			if($cash['cash_log']=="SUPERMARKET")
			{
				$totalAllCash +=$totalSM;
			}
			else
			{
				$totalAllCash +=$cash['totalCash'];
			}
			
		}
		return $totalAllCash;
	}
	
	public function sumAllDenomination($denomination)
	{
		$total = 0;
		foreach($denomination as $key2 => $amount)
		{
			$total +=$amount;
		}
		return round($total,2);
	}
	
	public function adjandCPO($cpo, $adj)
	{
		$data       = Array();
		$id         = 0;
		foreach ($adj as $key => $ad)
		{
			$data[] = [$key, $ad[0], round($ad[1],2)];
			$id     = $key;
		}
		foreach ($cpo as $key => $cp)
		{
			$id     += $cp->id;
			$dep    = explode("/", $cp->department->dep_name);
			$dep    = trim($dep[1]);
			$data[] = [$id, $dep, round($cp->amount_edited,2)];
		}
		return $data;
	}
	
	public function checkClass(Request $request,$checkClass,$date)
	{
		$login_user  = $request->user('api');
		$checks      = Checks::where('check_received','<=',$date)->where('date_deposit',null)
					 ->where('check_class',$checkClass)
					 ->where('businessunit_id',$login_user->bunitid)
					 ->get();
		return $checks;
	}
	
	public function addLogs(Request $request)
	{
		$login_user = $request->user('api');
		$salesData  = [
						'sales_date'    => date("Y-m-d",strtotime($request->sales_date)),
                        'ds_no'         => $request->ds_no,
                        'amount'        => str_replace(",","",$request->amount),
                        'amount_edited' => str_replace(",","",$request->amount_edited),
                        'ar_from'       => $request->ar_from,
                        'ar_to'         => $request->ar_to,
                        'cash_id'       => $request->cash_id,
						'company'       => $login_user->company_id,
						'bu_unit'       => $login_user->bunitid,
						'status_clerk'  => 'posted'
                     ];
		CashLogBook::updateOrCreate($salesData);
		
	}
	
	public function allLogsData(Request $request)
	{
		dd($request->salesDate);
	}
	

}
