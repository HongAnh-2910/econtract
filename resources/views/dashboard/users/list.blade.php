@extends('layouts.admin')
@section('content')
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách thành viên</h5>
                <div class="form-search form-inline">
                    <form action="">
                        <input value="{{ request()->input('search') }}" name="search" type="" class="form-control form-search" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if(request()->input('status') != 'trash')
                    <div class="analytic">
                        <a href="{{ request()->fullUrlWithQuery(['status'=>'trash']) }}" class="text-primary">Thùng
                            rác<span class="text-muted">({{ $countTrash }})</span></a>
                    </div>
                @endif
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" id="" name="action">
                        <option value="">Chọn</option>
                        @foreach($status as $k=>$v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="checkall">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Họ tên</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Quyền</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Ngày cập nhật</th>
                        @if(request()->input('status') != 'trash')
                            <th scope="col">Tác vụ</th>
                        @endif
                    </tr>
                    </thead>
                    @if($listUser->count() > 0)
                        <tbody>

                        @foreach($listUser as $key => $user )
                            <tr>
                                <td>
                                    <input type="checkbox" name="listCheck[]" value="{{ $user->id }}">
                                </td>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $user->name }}</td>
                                <td>phancuong</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role_string }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
                                @if(request()->input('status') != 'trash')
                                    <td class="d-flex">
                                        <div class="edit">
                                            <a href="{{ route('user.edit', $user->id) }}"
                                               class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                               data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                        </div>
                                        @if(Auth::id() != $user->id)
                                        <form method="POST" action="{{ route('user.delete', $user->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Bạn có chắc chắn muốn xoá thành viên')"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="submit"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    @else
                        @if(request()->input('status') != 'trash')
                            <p class="text-danger">Danh sách thành viên không tồn tại</p>
                        @else
                            <p class="text-danger">Chưa có bản ghi nào được xoá</p>
                        @endif
                    @endif
                </table>
                <nav aria-label="Page navigation example">
                    {{ $listUser->links() }}
                </nav>
            </div>
        </div>
    </div>
@endsection

