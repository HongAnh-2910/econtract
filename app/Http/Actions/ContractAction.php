<?php

namespace App\Http\Actions;

use App\Models\Banking;
use App\Models\Contract;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ContractAction
{
    protected $folder;
    protected $banking;
    protected $contract;

    public function __construct(Folder $folder, Banking $banking, Contract $contract)
    {
        $this->folder = $folder;
        $this->banking = $banking;
        $this->contract = $contract;
    }

    function getData($request)
    {
        $infoCty = [];
        if ($request->input('data') == '0108301796') {
            $infoCty = [
                'Title' => 'Công Ty Cổ Phần Canary Software',
                "ChuSoHuu" => "Nguyễn Minh Tường",
                "email" => "nguyenminhtruong@gmail.com",
                "DiaChiCongTy" => "Tầng 4, số 55, Lô TT6, Khu đô thị Văn Phú, Phường Phú La, Quận Hà Đông, Thành phố Hà Nội",
            ];
        }
        echo json_encode($infoCty);
    }

    public function searchAjax($request)
    {
        $search = '';
        if ($request->input('search')) {
            $search = $request->input('search');
        }

        return $this->folder::where([
            ['id', Auth::id()],
            ['parent_id', null],
        ])->first()->children()->where("name", "LIKE", "%{$search}%")->get();
    }

    public function searchBanking($request)
    {
        return $this->banking::where('vn_name', 'LIKE', "%{$request}%")
            ->orWhere('en_name', 'LIKE', "%{$request}%")
            ->orWhere('shortName', 'LIKE', "%{$request}%")
            ->limit(5)->get();
    }

    public function convertContractsToArray($contracts, $key): array
    {
        $arrayContracts = [];

        array_map(function ($array) use (&$arrayContracts, $key) {
            $arrayContracts[$array[$key]] = $array['data'];
        }, $contracts);

        return $arrayContracts;
    }

    public function statusActiveContractResponsive($request)
    {
        $statusContract = 0;
        switch ($request->status) {
            case 'new':
                $statusContract = 1;
                break;
            case 'wait_approval':
                $statusContract = 2;
                break;
            case 'close_approval':
                $statusContract = 3;
                break;
            case 'success':
                $statusContract = 4;
                break;
            case 'canceled':
                $statusContract = 5;
                break;
            default:
                $statusContract = 0;
        }
        return $statusContract;
    }

    public function create()
    {

        return $this->folder::where([
            ['user_id', Auth::id()],
            ['parent_id', null],
        ])->first();
    }

    public function getContractsViaMonth(User $user)
    {
        return $this->contract::with('file')->selectRaw('year(created_contract) year, DATE_FORMAT(created_contract, "%b") as abbMonthName, count(*) data')
            ->where('user_id', $user->id)
            ->groupBy('year', 'abbMonthName')
            ->orderBy('created_contract', 'asc')
            ->get();
    }

    public function getContractsGroupByStatus(User $user, $keyword = null)
    {
        $qb = $this->contract::with('file')->selectRaw('status, count(*) data')
            ->where('user_id', $user->id);

        if ($keyword) {
            $qb = $qb->where('code', 'like', '%' . $keyword . '%');
        }

        return $qb->groupBy('status')
            ->get();
    }

    public function getContractsViaStatus(User $user, $status, $keyword, $type = 'personal')
    {
        $qb = $this->contract::with('file')->select('contracts.id', 'contracts.code', 'contracts.status', 'contracts.name_customer', 'contracts.created_at')
            ->leftJoin('signatures', 'signatures.contract_id', 'contracts.id');
        $qb = $qb->where(function ($query) use ($user) {
            $query->where('contracts.user_id', $user->id)->orWhere('signatures.client_id', $user->id);
        })->where('contracts.type', $type)->groupBy('contracts.id');
        if ($status) {
            $qb = $qb->having('status', 'like', $status)->orderByDesc('created_at')->paginate();
        } elseif ($keyword) {
            $qb = $qb->having('code', 'like', '%' . $keyword . '%')->orderByDesc('created_at')->paginate();
        } else {
            $qb = $qb->orderByDesc('created_at')->paginate();
        }
        return $qb;
    }
}
