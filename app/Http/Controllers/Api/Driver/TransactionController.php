<?php

namespace App\Http\Controllers\Api\Driver;

use App\Enums\BankTransactionStatus;
use App\Enums\WalletActivityType;
use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\BankTransaction;
use App\Models\WalletActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    //

    /**
     * Change auth locale preference
     *
     * @api GET api/transaction/list_banks
     * @param Request $request
     * @return Response
     */
    public function list_banks(Request $request)
    {
        $banks = BankAccount::with('banks')->get();
        return response()->api($banks);
    }


    /**
     * Change auth locale preference
     *
     * @api POST api/transaction/bank_transaction
     * @param Request $request
     * @return Response
     */
    public function bank_transaction(Request $request)
    {
        $request->validate([
            'driver_id' => 'required',
            'transaction_date' => 'required',
            'reference_no' => 'required',
            'amount' => 'required',
            'account_holder_name' => 'required',
            'bank_name' => 'required',
            'image' => 'required',
            'account_no' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $id = BankTransaction::create([
                'driver_id' =>   $request->user()->id,
                'transaction_date' => $request->transaction_date,
                'reference_no' => $request->reference_no,
                'amount' => $request->amount,
                'account_holder_name' => $request->account_holder_name,
                'bank_name' => $request->bank_name,
                'image' => $request->image->store(BankTransaction::IMAGEPATH),
                'account_no' => $request->account_no,
                'status' => BankTransactionStatus::Pending
            ])->id;
            DB::commit();
            if ($id)
                return response()->api(BankTransaction::find($id), 'Transaction Created Sucssfully');
        } catch (\Throwable $th) {
            return response()->error($th, 400);
        }
    }


       /**
     * list all bank transactions
     *
     * @api GET api/transaction/list_bank_transaction
     * @param Request $request
     * @return Response
     */
    public function list_bank_transaction(Request $request)
    {
        $bank_trans = BankTransaction::where('driver_id',$request->user()->id)->get();
        
        return response()->api($bank_trans);
    }

         /**
     * list all bank transactions
     *
     * @api GET api/driver/get_walllet_balance
     * @param Request $request
     * @return Response
     */
    public function get_walllet_balance(Request $request)
    {
        $wallet_credit = WalletActivity::where('driver_id',$request->user()->id)->where('type',WalletActivityType::Credit )->sum('amount');
        $wallet_debit = WalletActivity::where('driver_id',$request->user()->id)->where('type',WalletActivityType::Debit )->sum('amount');
        
      $net_total=$wallet_credit-$wallet_debit;

      $data=
      [
          'credit'=>$wallet_credit,
          'debit'=>$wallet_debit,
          'net_total'=>$net_total

      ];
        
        return response()->api($data);
    }
}
