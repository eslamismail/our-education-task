<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions = file_get_contents('transactions.json');
        $transactions = json_decode($transactions, true);

        $transactions = $transactions['transactions'];
        $transactions = collect($transactions)->map(function ($item) {
            // $item['created_at'] = Carbon::parse(str_replace('/', '-', $item['created_at']));
            $item['paymentDate'] = Carbon::parse($item['paymentDate']);
            $item['created_at'] = Carbon::parse(str_replace('/', '-', $item['paymentDate']));
            $item['updated_at'] = Carbon::parse(str_replace('/', '-', $item['paymentDate']));
            return $item;
        })->toArray();

        Transaction::insert($transactions);
    }
}
