@if (count($customers) == 0)
    <tr>
        <td colspan="9" class="text-center">Không có dữ liệu...</td>
    </tr>
@else
    @foreach ($customers as $customer)
        <tr class="border-bottom text-center" id="results">
            <td>
                <input class="checkbox" type="checkbox" data-id="{{ $customer->id }}">
            </td>
            <td>
                <img src="{{ asset('images/admin.png') }}" alt="avatar" class="image__permission--round rounded-circle customer__table--img" />
            </td>
            <td>{{ $customer->customer_code }}</td>
            <td>
                <a type="button" data-uri="{{ route('web.customers.show', $customer->id) }}"
                    data-id="{{ $customer->id }}" id="showCustomerButton" class="btn ml-1 customer__list--name"
                    data-bs-toggle="modal" data-toggle="modal" data-bs-target="#showCustomer">
                    {{ $customer->name }}
                </a>

            </td>
            @if ($customer->customer_type == 'enterprise')
                <td>Doanh nghiệp</td>
            @elseif($customer->customer_type == 'personal')
                <td>Cá Nhân</td>
            @elseif($customer->customer_type == null)
                <td class="customerType__null--td"></td>
            @endif
            <td>{{ $customer->phone_number }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ date('d/m/Y', strtotime($customer->created_at)) }}</td>
            @if (request()->input('status') == 'deleted')
                <td>
                    <div class="customer__dropdown--list">
                        <i class="fas fa-ellipsis-h list__customers--color--cursor" style="font-size: 1.5em"></i>
                        <div class="dropdown-content">
                            <a type="button" href="{{ route('web.customers.restore', $customer->id) }}"
                                onclick="return confirm('Bạn muốn khôi phục thật chứ ?')" class="dropdown-item">
                                <img src="{{ asset('images/restore_from_trash_black.png') }}" alt="trash"> Khôi
                                phục</a>
                            <a type="button" href="{{ route('web.customers.permanentlyDeleted', $customer->id) }}"
                                onclick="return confirm('Bạn muốn xóa vinh vien thật không ?')" class="dropdown-item">
                                <i class="fa fa-trash"></i> Xoá vĩnh viễn</a>
                        </div>
                    </div>
                </td>
            @else
                <td>
                    <div class="customer__dropdown--list">
                        <i class="fas fa-ellipsis-h list__customers--color--cursor"></i>
                        <div class="dropdown-content">
                            <a type="button" href="{{ route('web.customers.delete', $customer->id) }}"
                                onclick="return confirm('Bạn muốn xóa thật không ?')" class="dropdown-item"><i
                                    class="fa fa-trash"></i> Xoá</a>
                        </div>
                    </div>
                </td>
            @endif
        </tr>
    @endforeach
    @endif
