<?php

namespace App\Http\Actions;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerAction
{
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function listCustomer($request)
    {
        $status = $request->input('status');
        $search = $request->input('search');
        $query = $this->customer::where('user_id', Auth::id())->latest('id');
        switch ($status) {
            case $this->customer::INDIVIDUAL:
                $customers = $query->IsSearchName($search)->TypeCustomer($this->customer::INDIVIDUAL);
                break;
            case $this->customer::ENTERPRISE:
                $customers = $query->IsSearchName($search)->TypeCustomer($this->customer::ENTERPRISE);
                break;
            case $this->customer::DELETED:
                $customers = $query->IsSearchName($search)->onlyTrashed();
                break;
            default:
                $customers = $query->IsSearchName($search);
        }
        return $customers->paginate();
    }

    public function create($data)
    {
        $customer = $this->customer->create($data);
        $randomNumber = rand(0, 99999);
        $styleNumber = str_pad($randomNumber, 5, '0', STR_PAD_LEFT);
        $customerCodeRandom = 'ONESIGN-' . $styleNumber;
        $customer->customer_code = $customerCodeRandom;
        $customer->user_id = Auth::id();
        $customer->save();
        return $customer;
    }

    public function findById($id)
    {
        return $this->customer->findOrFail($id);
    }

    public function update($id, $data)
    {
        $customer = $this->customer->findOrFail($id);
        $customer->fill($data);
        $customer->save();
        return $customer;
    }

    public function delete($id)
    {
        return $this->customer->where('id', $id)->delete();
    }

    public function search($keyword)
    {
        return $this->customer->select("id", "name")->SearchName($keyword)
            ->get();
    }

    public function statusCustomerResponsive($request)
    {
        switch ($request->status) {
            case config('statuses.personal'):
                $statusCustomer = 1;
                break;
            case config('statuses.enterprise'):
                $statusCustomer = 2;
                break;
            case config('statuses.delete'):
                $statusCustomer = 3;
                break;
            default:
                $statusCustomer = 0;
        }
        return $statusCustomer;
    }
}
