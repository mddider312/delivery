<?php

namespace App\Controllers;

use App\Controllers\BaseController;
//use App\Models\Partner;
//use App\Models\Product;
//use App\Models\Transaction;
use Carbon\Carbon;
class DashboardController extends BaseController
{
    public function __construct() {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d");
        $this->db = \Config\Database::connect();
        
       // $this->transactionModel = new Transaction();
       // $this->productModel = new Product();
        //$this->partnerModel = new Partner();
    }
    
	public function index()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Dashboard']),
			'page_title' => view('partials/page-title', ['title' => 'Dashboard', 'li_1' => 'Dashboard']),
			//'today_sales'	=> $this->_today_sales(),
			//'total_partners' => $this->partnerModel->countAllResults(),
			//'sales_report'	=> $this->_sales_report(),
			//'partners'	=> $this->_partners(),
			//'latest_transactions'	=> $this->_latest_transactions()
		];
		return view('dashboard', $data);
	}

	private function _today_sales()
	{
		$today_start = Carbon::today()->startOfDay()->format('Y-m-d H:i:s');
		$today_end = Carbon::today()->endOfDay()->format('Y-m-d H:i:s');
		$today_total = $this->transactionModel->count($today_start,$today_end,['sale']);

		$yesterday_start = Carbon::yesterday()->startOfDay()->format('Y-m-d H:i:s');
		$yesterday_end = Carbon::yesterday()->endOfDay()->format('Y-m-d H:i:s');
		$yesterday_total = $this->transactionModel->count($yesterday_start,$yesterday_end,['sale']);

		return 
		[
			'total' =>  $today_total, 	
			'increments' => (($today_total - $yesterday_total) / (($today_total == 0) ? 1 : $today_total)) * 100,
		];	
	}

	private function _sales_report()
	{
		$today = Carbon::now();
		$current_year = (int)$today->format('Y');
		$last_year = (int)$today->subYears(1)->format('Y');
		return 
		[
			'label'	=> [
				Carbon::now()->subMonths(6)->format('M'),
				Carbon::now()->subMonths(5)->format('M'),
				Carbon::now()->subMonths(4)->format('M'),
				Carbon::now()->subMonths(3)->format('M'),
				Carbon::now()->subMonths(2)->format('M'),
				Carbon::now()->subMonths(1)->format('M'),
				Carbon::now()->format('M')],
			'current_year' 	=> [
				'year'			=> $current_year,
				'dataset'		=> 
				[
					$this->transactionModel->count(Carbon::now()->subMonths(6)->startOfMonth()->startOfDay()->format('Y-m-d H:i:s'),Carbon::now()->subMonths(6)->endOfMonth()->endOfDay()->format('Y-m-d H:i:s'),['sale']),
					$this->transactionModel->count(Carbon::now()->subMonths(5)->startOfMonth()->startOfDay()->format('Y-m-d H:i:s'),Carbon::now()->subMonths(5)->endOfMonth()->endOfDay()->format('Y-m-d H:i:s'),['sale']),
					$this->transactionModel->count(Carbon::now()->subMonths(4)->startOfMonth()->startOfDay()->format('Y-m-d H:i:s'),Carbon::now()->subMonths(4)->endOfMonth()->endOfDay()->format('Y-m-d H:i:s'),['sale']),
					$this->transactionModel->count(Carbon::now()->subMonths(3)->startOfMonth()->startOfDay()->format('Y-m-d H:i:s'),Carbon::now()->subMonths(3)->endOfMonth()->endOfDay()->format('Y-m-d H:i:s'),['sale']),
					$this->transactionModel->count(Carbon::now()->subMonths(2)->startOfMonth()->startOfDay()->format('Y-m-d H:i:s'),Carbon::now()->subMonths(2)->endOfMonth()->endOfDay()->format('Y-m-d H:i:s'),['sale']),
					$this->transactionModel->count(Carbon::now()->subMonths(1)->startOfMonth()->startOfDay()->format('Y-m-d H:i:s'),Carbon::now()->subMonths(1)->endOfMonth()->endOfDay()->format('Y-m-d H:i:s'),['sale']),
					$this->transactionModel->count(Carbon::now()->startOfMonth()->startOfDay()->format('Y-m-d H:i:s'),Carbon::now()->endOfMonth()->endOfDay()->format('Y-m-d H:i:s'),['sale']),
				]
			],
			'last_year'		=> [
				'year'			=> $last_year,
				'dataset'		=> [
					$this->transactionModel->count(Carbon::now()->subMonths(6)->startOfMonth()->startOfDay()->subYears(1)->format('Y-m-d H:i:s'),Carbon::now()->subMonths(6)->endOfMonth()->endOfDay()->subYears(1)->format('Y-m-d H:i:s'),['sale']),
					$this->transactionModel->count(Carbon::now()->subMonths(5)->startOfMonth()->startOfDay()->subYears(1)->format('Y-m-d H:i:s'),Carbon::now()->subMonths(5)->endOfMonth()->endOfDay()->subYears(1)->format('Y-m-d H:i:s'),['sale']),
					$this->transactionModel->count(Carbon::now()->subMonths(4)->startOfMonth()->startOfDay()->subYears(1)->format('Y-m-d H:i:s'),Carbon::now()->subMonths(4)->endOfMonth()->endOfDay()->subYears(1)->format('Y-m-d H:i:s'),['sale']),
					$this->transactionModel->count(Carbon::now()->subMonths(3)->startOfMonth()->startOfDay()->subYears(1)->format('Y-m-d H:i:s'),Carbon::now()->subMonths(3)->endOfMonth()->endOfDay()->subYears(1)->format('Y-m-d H:i:s'),['sale']),
					$this->transactionModel->count(Carbon::now()->subMonths(2)->startOfMonth()->startOfDay()->subYears(1)->format('Y-m-d H:i:s'),Carbon::now()->subMonths(2)->endOfMonth()->endOfDay()->subYears(1)->format('Y-m-d H:i:s'),['sale']),
					$this->transactionModel->count(Carbon::now()->subMonths(1)->startOfMonth()->startOfDay()->subYears(1)->format('Y-m-d H:i:s'),Carbon::now()->subMonths(1)->endOfMonth()->endOfDay()->subYears(1)->format('Y-m-d H:i:s'),['sale']),
					$this->transactionModel->count(Carbon::now()->startOfMonth()->startOfDay()->subYears(1)->format('Y-m-d H:i:s'),Carbon::now()->endOfMonth()->endOfDay()->subYears(1)->format('Y-m-d H:i:s'),['sale']),
				]
			]
		];
	}

	private function _partners()
	{
		$partners  =  $this->partnerModel->orderBy('id DESC')->findAll(4);
		foreach ($partners as $key => $partner) 
		{
			$partners[$key]['initial'] = $this->_initials($partner['name']);
			$partners[$key]['avatars'] = substr(md5($partners[$key]['initial']), 0, 6);
		}

		return $partners;
	}

	public function _latest_transactions()
	{
		$transactions =  $this->transactionModel->orderBy('id DESC')->findAll(4);
		foreach($transactions as $key => $transaction)
		{
			$transactions[$key]['product'] = $this->productModel->find($transaction['product_id']);
			$transactions[$key]['partner'] = $this->partnerModel->find($transaction['partner_id']);
		}

		return $transactions;
	}

	private function _initials(string $name) : string
    {
        $words = explode(' ', $name);
        if (count($words) >= 2) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8') .
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8'
            );
    	}
        return $this->_makeInitialsFromSingleWord($name);
    }

    /**
     * Make initials from a word with no spaces
     *
     * @param string $name
     * @return string
     */
    private function _makeInitialsFromSingleWord(string $name) : string
    {
        preg_match_all('#([A-Z]+)#', $name, $capitals);
        if (count($capitals[1]) >= 2) {
            return mb_substr(implode('', $capitals[1]), 0, 2, 'UTF-8');
        }
        return mb_strtoupper(mb_substr($name, 0, 2, 'UTF-8'), 'UTF-8');
    }





}
