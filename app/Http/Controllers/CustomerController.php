<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Http\Actions\CustomerAction;
use App\Http\Requests\ValidateCustomerRequest;
use App\Imports\CustomersImport;
use App\Models\Banking;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    protected $customerAction;

    public function __construct(CustomerAction $customerAction)
    {
        $this->customerAction = $customerAction;
    }

    public function index(Request $request)
    {
        $customers = $this->customerAction->listCustomer($request);
        $customerTypeIsPersonal = Customer::where('user_id', Auth::id())->where('customer_type', 'Cá nhân')->count();
        $customerTypeIsEnterprise = Customer::where('user_id', Auth::id())->where('customer_type', 'Doanh nghiệp')->count();
        $countCustomer = Customer::where('user_id', Auth::id())->whereNull('deleted_at')->count();
        $countSoftDelete = Customer::onlyTrashed()->where('user_id', Auth::id())->count();
        $statusCustomer = $this->customerAction->statusCustomerResponsive($request);

        return view('dashboard.customer.list', compact('customers', 'customerTypeIsPersonal', 'customerTypeIsEnterprise', 'countSoftDelete', 'countCustomer', 'statusCustomer'));
    }

    public function store(ValidateCustomerRequest $request)
    {
        $this->customerAction->create($request->all());
        Session::flash('success', 'Bạn đã thêm khách hàng thành công');

        return redirect()->route('web.customers.list');
    }

    public function show($id)
    {
        $customer = Customer::find($id);
        echo json_encode($customer);
    }

    public function update(Request $request, $id)
    {
        $this->customerAction->update($id, $request->all());

        Session::flash('success', 'Bạn đã sửa khách hàng thành công');

        return redirect()->route('web.customers.list');
    }

    public function delete($id)
    {
        $this->customerAction->delete($id);

        return redirect()->route('web.customers.list')->with('success', 'Bạn đã xóa khách hàng thành công');
    }

    public function deleteMultipleCustomer(Request $request)
    {
        $ids = $request->ids;
        Customer::whereIn('id', explode(',', $ids))->delete();

        Session::flash('success', 'Bạn đã xóa khách hàng thành công');
        return response()->json(['status' => 'true']);
    }

    public function liveSearch(Request $request)
    {
        $keyword = $request->input('keyword');
        $customers = Customer::where("name", "LIKE", "%{$keyword}%")
            ->orWhere("customer_code", "LIKE", "%{$keyword}%")
            ->orWhere("tax_code", "LIKE", "%{$keyword}%")
            ->orWhere("name_company", "LIKE", "%{$keyword}%")
            ->get();

        return view('dashboard.customer.search_customer', compact('customers'));
    }

    public function restore($id)
    {
        Customer::withTrashed()->where('id', $id)->restore();

        return redirect()->route('web.customers.list')->with('success', 'Bạn đã khôi phục thành công');
    }

    public function restoreMultipleCustomer(Request $request)
    {
        $ids = $request->ids;
        Customer::withTrashed()->whereIn('id', explode(',', $ids))->restore();

        return redirect()->route('web.customers.list')->with('success', 'Bạn đã khôi phục thành công');

    }

    public function permanentlyDeleted($id)
    {
        Customer::withTrashed()->where('id', $id)->forceDelete();

        return redirect()->route('web.customers.list')->with('success', 'Bạn đã xóa khách hàng vĩnh viễn');

    }

    public function permanentlyDeletedMultipleCustomer(Request $request)
    {
        $ids = $request->ids;
        Customer::withTrashed()->whereIn('id', explode(',', $ids))->forceDelete();

        return redirect()->route('web.customers.list')->with('success', 'Bạn đã vĩnh viễn thành công');

    }

    public function destroy(Request $request)
    {
        $ids = $request->ids;
        DB::table('customers')->whereIn('id', explode(',', $ids))->delete();
        return response()->json(['success' => "Products Deleted successfully."]);
    }

    public function getBankingName(Request $request)
    {
        $nameBank = $request->input('keywork');
        if ($nameBank == null) {
            $bankList = Banking::all();
        } else {
            $bankList = Banking::where('vn_name', 'LIKE', "%{$nameBank}%")
                ->orWhere('en_name', 'LIKE', "%{$nameBank}%")
                ->orWhere('shortName', 'LIKE', "%{$nameBank}%")
                ->get();
        }

        return view('dashboard.customer.search_banking_ajax', compact('bankList'));
    }

    public function exportExcel()
    {
        return Excel::download(new CustomersExport, 'Danh sách khách hàng.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|max:10000|mimes:xlsx,xls',
        ]);

        $file = $request->file('file')->store('temp');
        $path = storage_path('app') . '/' . $file;

        $import = new CustomersImport;
        $import->import($path);
        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        Session::flash('success', 'Bạn đã nhập dữ liệu thành công');
        return redirect()->route('web.customers.list');
    }
}
