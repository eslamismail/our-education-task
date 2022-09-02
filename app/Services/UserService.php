<?php

namespace App\Services;

use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserService implements UserInterface
{

    /*
    adding filter method
    if no data passing to this function it will return all data
     */
    public function filter(array $data = []): array
    {
        // get column names from table
        $columns = Schema::getColumnListing('transactions');
        // handle GROUP CONCAT keys with sql  format
        $groupKeys = collect($columns)->map(function ($item, $key) {
            $columnString = $key == 0 ? "transactions.$item" : "'|', transactions.$item";
            return $columnString;
        })->toArray();
        //   conver it to string to pass it to sql query
        $groupKeys = implode(',', $groupKeys);

        $users = User::select('users.*')
            ->join('transactions', 'users.email', '=', 'transactions.parentEmail')
            ->addSelect(DB::raw("GROUP_CONCAT($groupKeys) as transactions"))
            ->when(!empty($data['statusCode']), fn($q) => $q->where('transactions.statusCode', $data['statusCode']))
            ->when(!empty($data['paidAmount']), fn($q) => $q->where('transactions.paidAmount', $data['paidAmount']))
            ->when(!empty($data['currency']), fn($q) => $q->where('transactions.currency', $data['currency']))
            ->when(!empty($data['paymentDateFrom']) || !empty($data['paymentDate']),
                fn($q) => $q->whereBetween('transactions.paymentDate', [
                    $data['paymentDateFrom'],
                    $data['paymentDateTo'],
                ]))
            ->groupBy('users.email')
            ->get();
        // resolve transactions array
        $users = collect($users)->map(function ($item) use ($columns) {
            $transactions = [];
            // get many transactions to array
            $group = explode(",", $item['transactions']);
            foreach ($group as $key => $s) {
                // get every column value to array
                $values = explode("|", $s);
                $data = [];
                // loop in coumn names and get exists value from our selected values
                foreach ($columns as $key => $column) {
                    $data[$column] = $values[$key] ?? null;
                }
                $transactions[] = $data;
            }
            // overwrite new data in transactions key in user array
            $item['transactions'] = $transactions;
            return $item;
        })->toArray();

        // here is my output
        return $users;
    }
}
