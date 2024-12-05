@extends('master_layout.layout')

@section('styles')
    <style>
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('scripts')
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8 shadow">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Yêu Cầu Mua Hàng</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('equipment_request.import_trash') }}"
                    class="btn btn-sm rounded-pill btn-danger me-2 rounded-pill">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-trash me-1"></i>
                        Thùng Rác
                    </span>
                </a>
                <a href="{{ route('equipment_request.create_import') }}" class="btn btn-success btn-sm rounded-pill">
                    <i class="fa fa-plus me-1" style="margin-bottom: 2px;"></i>Tạo Phiếu
                </a>
            </div>
        </div>
        <div class="card-body py-1">
            <form action="{{ route('equipment_request.import') }}" class="row align-items-center">
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <select name="spr" class="mt-2 mb-2 form-select form-select-sm rounded-pill setupSelect2 w-100">
                        <option value="" selected>--Theo Nhà Cung Cấp--</option>
                        @foreach ($AllSupplier as $item)
                            <option value="{{ $item->code }}" {{ request()->spr == $item->code ? 'selected' : '' }}>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-12">
                    <select name="us" class="mt-2 mb-2 form-select form-select-sm rounded-pill setupSelect2 w-100">
                        <option value="" selected>--Theo Người Tạo--</option>
                        @foreach ($AllUser as $item)
                            <option value="{{ $item->code }}" {{ request()->us == $item->code ? 'selected' : '' }}>
                                {{ $item->last_name . ' ' . $item->first_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-12">
                    <select name="stt" class="mt-2 mb-2 form-select form-select-sm rounded-pill setupSelect2 w-100">
                        <option value="" {{ request()->stt == '' ? 'selected' : '' }}>--Theo Trạng Thái--</option>
                        <option value="0" {{ request()->stt == '0' ? 'selected' : '' }}>Chờ Duyệt</option>
                        <option value="1" {{ request()->stt == '1' ? 'selected' : '' }}>Đang Nhập Kho</option>
                        <option value="2" {{ request()->stt == '2' ? 'selected' : '' }}>Chờ Báo Giá</option>
                        <option value="5" {{ request()->stt == '5' ? 'selected' : '' }}>Bị Từ Chối</option>
                        <option value="3" {{ request()->stt == '3' ? 'selected' : '' }}>Lưu Tạm</option>
                        <option value="4" {{ request()->stt == '4' ? 'selected' : '' }}>Hoàn Thành</option>
                    </select>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <input type="search" name="kw" placeholder="Tìm kiếm mã phiếu yêu cầu mua hàng.."
                                class="mt-2 mb-2 form-control form-control-sm rounded-pill border border-success w-100"
                                value="{{ request()->kw }}">
                        </div>
                        <div class="col-md-6 d-flex">
                            <a class="btn rounded-pill btn-info btn-sm mt-2 mb-2 w-100 me-2"
                                href="{{ route('equipment_request.import') }}"><i class="fas fa-times-circle"
                                    style="margin-bottom: 2px;"></i> Bỏ
                                Lọc</a>
                            <button class="btn rounded-pill btn-dark btn-sm mt-2 mb-2 w-100 load_animation"
                                type="submit"><i class="fa fa-search" style="margin-bottom: 2px;"></i>Tìm</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <form action="{{ route('equipment_request.import') }}" method="POST">
            @csrf
            <input type="hidden" name="action_type" id="action_type" value="">
            <div class="card-body py-3">
                <div class="table-responsive rounded">
                    <table class="table align-middle gs-0 gy-4">
                        <thead class="{{ $AllEquipmentRequest->count() == 0 ? 'd-none' : '' }}">
                            <tr class="bg-success fw-bolder">
                                <th class="ps-3">
                                    <input type="checkbox" id="selectAll" />
                                </th>
                                <th class="" style="width: 10%;">Mã yêu cầu</th>
                                <th class="" style="width: 43%;">Nhà cung cấp</th>
                                <th class="" style="width: 12%;">Người tạo</th>
                                <th class="" style="width: 10%;">Ngày yêu cầu</th>
                                <th class="text-center" style="width: 10%;">Trạng thái</th>
                                <th class="pe-3 text-center" style="width: 15%;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($AllEquipmentRequest as $item)
                                <tr class="hover-table pointer">
                                    <td>
                                        {{-- Phiếu tạm => ẩn hết, phiếu chờ duyệt thì hiện, phiếu đã duyệt chưa tạo thì hiện icon, phiếu đã duyệt tạo rồi thì ẩn --}}
                                        @if ($item->status == 0)
                                            <input type="checkbox" name="import_request_codes[]"
                                                value="{{ $item->code }}" class="row-checkbox" />
                                        @elseif ($item->status == 3)
                                            <i class="fa fa-clock text-dark" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Lưu Tạm"></i>
                                        @elseif ($item->status == 2)
                                            <i class="fa fa-clock text-dark" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Chờ Báo Giá"></i>
                                        @elseif ($item->status == 1)
                                            <i class="fa-solid fa-circle-exclamation text-danger" style="font-size: 13px;"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Phiếu Yêu Cầu Chưa Được Nhập Kho"></i>
                                        @elseif ($item->status == 5)
                                            <i class="fas fa-times-circle text-danger" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Bị từ chối"></i>
                                        @elseif ($item->status == 4)
                                            <i class="fa fa-check text-success" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Hoàn Thành"></i>
                                        @endif
                                    </td>
                                    <td>
                                        #{{ $item->code }}
                                    </td>
                                    <td>
                                        @if (!empty($item->supplier_code))
                                            <a class="text-decoration-underline fw-bolder"
                                                href="{{ route('supplier.list') }}?keyword={{ $item->suppliers->name }}">
                                                {{ $item->suppliers->name }}
                                            </a>
                                        @else
                                            Chưa có
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->user_code == session('user_code'))
                                            {{ $item->users->last_name . ' ' . $item->users->first_name }} <i
                                                class="fa fa-user" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Tôi"></i>
                                        @else
                                            {{ $item->users->last_name . ' ' . $item->users->first_name }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->request_date)->format('d-m-Y') }}
                                    </td>
                                    <td class="text-center">
                                        @if ($item->status == 3)
                                            <div class="rounded-pill px-2 py-1 text-white bg-info">
                                                Lưu tạm
                                            </div>
                                        @elseif ($item->status == 0)
                                            <div class="rounded-pill px-2 py-1 text-white bg-danger">
                                                Chờ duyệt
                                            </div>
                                        @elseif ($item->status == 2)
                                            <div class="rounded-pill px-2 py-1 text-white bg-dark">
                                                Chờ báo giá
                                            </div>
                                        @elseif ($item->status == 5)
                                            <div class="rounded-pill px-2 py-1 text-dark bg-warning">
                                                Bị Từ Chối
                                            </div>
                                        @elseif ($item->status == 1)
                                            <div class="rounded-pill px-2 py-1 text-white bg-primary">
                                                Đang nhập
                                            </div>
                                        @elseif ($item->status == 4)
                                            <div class="rounded-pill px-2 py-1 text-white bg-success">
                                                Hoàn thành
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center" data-bs-toggle="collapse"
                                        data-bs-target="#collapse_{{ $item->code }}" aria-expanded="false"
                                        aria-controls="collapse_{{ $item->code }}">
                                        Chi tiết<i class="fa fa-caret-right pointer ms-2"></i>
                                    </td>
                                </tr>

                                <!-- Collapse content -->
                                <tr>
                                    <td class="p-0" colspan="12"
                                        style="background-color: #fafafa; padding-top: 0 !important;">
                                        <div class="flex-lg-row-fluid border-2 border-lg-1 collapse multi-collapse"
                                            id="collapse_{{ $item->code }}">
                                            <div class="flex-lg-row-fluid border-lg-1">
                                                <div class="card card-flush px-5" style="padding-top: 0px !important;">
                                                    <div class="card-header d-flex justify-content-between align-items-center px-2"
                                                        style="padding-top: 0 !important; padding-bottom: 0px !important;">
                                                        <h4 class="fw-bold m-0 text-uppercase fw-bolder">Danh Sách
                                                            Thiết Bị
                                                            Yêu
                                                            Cầu
                                                        </h4>
                                                        <div class="card-toolbar">
                                                            @if ($item->status == 3)
                                                                <div class="rounded-pill px-2 py-1 text-white bg-info">
                                                                    Lưu tạm
                                                                </div>
                                                            @elseif ($item->status == 0)
                                                                <div class="rounded-pill px-2 py-1 text-white bg-danger">
                                                                    Chờ duyệt
                                                                </div>
                                                            @elseif ($item->status == 2)
                                                                <div class="rounded-pill px-2 py-1 text-white bg-dark">
                                                                    Chờ báo giá
                                                                </div>
                                                            @elseif ($item->status == 5)
                                                                <button type="button" data-bs-toggle="modal"
                                                                    data-bs-target="#detail_reason_{{ $item->code }}"
                                                                    class="rounded-pill px-2 py-1 btn btn-dark btn-sm me-2">
                                                                    Xem Lý Do
                                                                </button>
                                                                <div class="rounded-pill px-2 py-1 text-dark bg-warning">
                                                                    Bị Từ Chối
                                                                </div>
                                                            @elseif ($item->status == 1)
                                                                <div class="rounded-pill px-2 py-1 text-white bg-primary">
                                                                    Đang nhập
                                                                </div>
                                                            @elseif ($item->status == 4)
                                                                <div class="rounded-pill px-2 py-1 text-white bg-success">
                                                                    Hoàn thành
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <span class="me-5">
                                                            Người sửa:
                                                            {{ $item->updatedByUser ? $item->updatedByUser->last_name . ' ' . $item->updatedByUser->first_name : 'N/A' }}
                                                        </span>
                                                        <span class="me-5">
                                                            Người {{ isset($item->reason_refuse) ? 'từ chối' : 'duyệt' }}:
                                                            {{ $item->browseByUser ? $item->browseByUser->last_name . ' ' . $item->browseByUser->first_name : 'N/A' }}
                                                        </span>
                                                    </div>
                                                    <div class="card-body p-0" style="padding-top: 0px !important">
                                                        <!-- Begin::Receipt Items (Right column) -->
                                                        <div class="col-md-12">
                                                            <div class="table-responsive rounded">
                                                                <table
                                                                    class="table table-striped table-sm table-hover mb-0">
                                                                    <thead class="bg-dark">
                                                                        <tr class="">
                                                                            <th class="ps-3">STT</th>
                                                                            <th>Tên thiết bị</th>
                                                                            <th>Đơn vị tính</th>
                                                                            <th data-bs-toggle="tooltip"
                                                                                data-bs-placement="top"
                                                                                title="Số Lượng Yêu Cầu">SLYC</th>
                                                                            @if ($item->status == 1 || $item->status == 4)
                                                                                <th data-bs-toggle="tooltip"
                                                                                    data-bs-placement="top"
                                                                                    title="Số Lượng Báo Giá">SLBG</th>
                                                                                <th>Lệch</th>
                                                                                <th>Đơn giá</th>
                                                                                <th class="pe-3"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-placement="top"
                                                                                    title="Bao gồm chiết khấu và thuế VAT">
                                                                                    Thành tiền</th>
                                                                            @endif
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @php
                                                                            $totalAmount = 0;
                                                                        @endphp
                                                                        @foreach ($item->import_equipment_request_details as $key => $detail)
                                                                            @php
                                                                                $price = $detail->price ?? 0;
                                                                                $quantity = $detail->quantity_quote;
                                                                                $discount = $detail->discount ?? 0;
                                                                                $vat = $detail->equipments->vat ?? 0;

                                                                                $totalPrice = $quantity * $price;

                                                                                $totalPriceWithDiscount =
                                                                                    $totalPrice * (1 - $discount / 100);

                                                                                $totalPriceWithVAT =
                                                                                    $totalPriceWithDiscount *
                                                                                    (1 + $vat / 100);

                                                                                $totalAmount += $totalPriceWithVAT;
                                                                            @endphp
                                                                            <tr class="">
                                                                                <td>{{ $key + 1 }}</td>
                                                                                <td>{{ $detail->equipments->name }}
                                                                                </td>
                                                                                <td>{{ $detail->equipments->units->name }}
                                                                                </td>
                                                                                <td>{{ $detail->quantity }}</td>
                                                                                @if ($item->status == 1 || $item->status == 4)
                                                                                    <td>{{ $detail->quantity_quote }}</td>
                                                                                    @if ($detail->deviation_quote === 'Không lệch')
                                                                                        <td>
                                                                                            {{ $detail->deviation_quote }}
                                                                                            <i
                                                                                                class="fa fa-check-circle text-success"></i>
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            {{ $detail->deviation_quote }}
                                                                                            <i
                                                                                                class="fa-solid fa-triangle-exclamation text-danger"></i>
                                                                                        </td>
                                                                                    @endif
                                                                                    <td>{{ number_format($detail->price, 0, ',', '.') }}
                                                                                        VND</td>
                                                                                    <td>{{ number_format($totalPriceWithVAT, 0, ',', '.') }}
                                                                                        VND
                                                                                    </td>
                                                                                @endif
                                                                            </tr>
                                                                        @endforeach
                                                                        <tr
                                                                            class="{{ $item->supplier_code ? '' : 'd-none' }}">
                                                                            <td colspan="7"
                                                                                class="text-start fw-bolder">Tổng Cộng
                                                                            </td>
                                                                            <td>
                                                                                {{ number_format($totalAmount, 0, ',', '.') }}
                                                                                VND
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-5 ms-3">
                                                        <i>Ghi Chú: {{ $item->note ?? '...' }}</i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-body py-5 text-end bg-white">
                                                <div class="button-group">
                                                    @if ($item->status == 0)
                                                        {{-- Chưa duyệt --}}

                                                        @if (session('isAdmin') == 1)
                                                            {{-- Nút từ chối --}}
                                                            <button class="btn btn-sm rounded-pill btn-danger me-2"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#noBrowse_{{ $item->code }}"
                                                                type="button">
                                                                <i class="fas fa-times-circle"
                                                                    style="margin-bottom: 2px;"></i>Từ Chối
                                                            </button>
                                                            <!-- Nút Duyệt đơn -->
                                                            <button class="btn btn-sm rounded-pill btn-success me-2"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#browse_{{ $item->code }}"
                                                                type="button">
                                                                <i class="fas fa-clipboard-check"
                                                                    style="margin-bottom: 2px;"></i>Duyệt phiếu
                                                            </button>
                                                        @endif

                                                        @if ($item->user_code == session('user_code'))
                                                            <!-- Nút Sửa đơn -->
                                                            <a href="{{ route('equipment_request.update_import', $item->code) }}"
                                                                class="btn btn-dark btn-sm me-2 rounded-pill">
                                                                <i class="fa fa-edit" style="margin-bottom: 2px;"></i>Sửa
                                                                phiếu
                                                            </a>

                                                            <!-- Nút Hủy đơn -->
                                                            <button class="btn btn-sm rounded-pill btn-danger me-2"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal_{{ $item->code }}"
                                                                type="button">
                                                                <i class="fa fa-trash" style="margin-bottom: 2px;"></i>Hủy
                                                                phiếu
                                                            </button>
                                                        @endif
                                                    @elseif ($item->status == 3 && $item->user_code == session('user_code'))
                                                        {{-- Lưu tạm --}}

                                                        <!-- Nút lưu phiếu -->
                                                        <button class="btn btn-sm rounded-pill btn-twitter me-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#save_{{ $item->code }}" type="button">
                                                            <i class="fa fa-save" style="margin-bottom: 2px;"></i>Tạo
                                                            phiếu
                                                        </button>

                                                        <!-- Nút Sửa đơn -->
                                                        <a href="{{ route('equipment_request.update_import', $item->code) }}"
                                                            class="btn btn-dark btn-sm me-2 rounded-pill">
                                                            <i class="fa fa-edit" style="margin-bottom: 2px;"></i>Sửa
                                                            phiếu
                                                        </a>

                                                        <!-- Nút Hủy đơn -->
                                                        <button class="btn btn-sm rounded-pill btn-danger me-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal_{{ $item->code }}"
                                                            type="button">
                                                            <i class="fa fa-trash" style="margin-bottom: 2px;"></i>Hủy
                                                            phiếu
                                                        </button>
                                                    @elseif ($item->status == 1)
                                                        @if (session('isAdmin') == 1)
                                                            <a href="{{ route('equipment_request.update_import', ['code' => $item->code, 'status' => 'update_quote']) }}"
                                                                class="btn btn-sm rounded-pill btn-dark me-2">
                                                                <i class="fas fa-edit" style="margin-bottom: 2px;"></i>
                                                                Cập nhật giá
                                                            </a>
                                                        @endif

                                                        <!-- Nút Tạo Phiếu Nhập -->
                                                        <a href="{{ route('warehouse.create_import') }}?cd={{ $item->code }}"
                                                            class="btn btn-sm rounded-pill btn-youtube me-2">
                                                            <i class="fas fa-file-import" style="margin-bottom: 2px;"></i>
                                                            Tạo phiếu nhập
                                                        </a>

                                                        <!-- Nút In Phiếu -->
                                                        <button class="btn btn-sm rounded-pill btn-twitter me-2"
                                                            onclick="printInvoice('{{ $item->code }}')" type="button">
                                                            <i class="fa fa-print" style="margin-bottom: 2px;"></i> In
                                                            phiếu
                                                        </button>
                                                    @elseif ($item->status == 2)
                                                        @if (session('isAdmin') == 1)
                                                            <button type="button"
                                                                class="checkbox-wrapper-6 me-2 btn btn-sm btn-dark rounded-pill">
                                                                <div class="d-flex align-items-center">
                                                                    Cho phép sửa
                                                                    <input class="tgl tgl-light" id="allow_to_edit"
                                                                        type="checkbox" value="1"
                                                                        name="allow_to_edit"
                                                                        {{ !empty($item->allow_to_edit) && $item->allow_to_edit == 1 ? 'checked' : '' }} />
                                                                    <label class="tgl-btn ms-2" for="allow_to_edit"
                                                                        style="width: 30px; height: 18px;"></label>
                                                                </div>
                                                            </button>

                                                            <script>
                                                                document.getElementById('allow_to_edit').addEventListener('change', function(event) {
                                                                    event.preventDefault();

                                                                    document.getElementById('loading').style.display = 'block';
                                                                    document.getElementById('loading-overlay').style.display = 'block';
                                                                    this.disabled = true;

                                                                    setTimeout(() => {
                                                                        const allow_to_edit = document.getElementById('allow_to_edit').checked ? 1 : 2;

                                                                        let formData = new FormData();
                                                                        formData.append('allow_to_edit', allow_to_edit);

                                                                        fetch('{{ route('equipment_request.allowToEdit', $item->code) }}', {
                                                                                method: 'POST',
                                                                                body: formData,
                                                                                headers: {
                                                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                                                }
                                                                            }).then(response => response.json())
                                                                            .then(data => {
                                                                                if (data.success) {
                                                                                    toastr.success(data.message);
                                                                                }

                                                                                if (data.hide == 1) {
                                                                                    document.getElementById('action_update_price').classList.add('d-none');
                                                                                } else {
                                                                                    document.getElementById('action_update_price').classList.remove(
                                                                                        'd-none');
                                                                                }
                                                                            })
                                                                            .catch(error => console.error('Error:', error))
                                                                            .finally(() => {
                                                                                document.getElementById('loading').style.display = 'none';
                                                                                document.getElementById('loading-overlay').style.display = 'none';
                                                                                this.disabled = false;
                                                                            });
                                                                    }, 500);
                                                                });
                                                            </script>
                                                        @endif

                                                        <span id="action_update_price"
                                                            class="{{ $item->allow_to_edit == 0 ? '' : 'd-none' }}">
                                                            <a href="{{ route('equipment_request.update_import', ['code' => $item->code, 'status' => 'update_quote']) }}"
                                                                class="btn btn-sm rounded-pill btn-youtube me-2">
                                                                <i class="fas fa-edit" style="margin-bottom: 2px;"></i>
                                                                Cập nhật giá
                                                            </a>
                                                            <a href="{{ route('equipment_request.exportPdfEquipmentRequestList', $item->code) }}"
                                                                class="btn btn-sm rounded-pill btn-twitter me-2">
                                                                <i class="fas fa-file-pdf"
                                                                    style="margin-bottom: 2px;"></i>
                                                                Tải yêu cầu báo giá
                                                            </a>
                                                        </span>

                                                        @if ($item->allow_to_edit == 1 && $item->user_code == session('user_code'))
                                                            <!-- Nút Sửa đơn -->
                                                            <a href="{{ route('equipment_request.update_import', $item->code) }}"
                                                                class="btn btn-twitter btn-sm me-2 rounded-pill">
                                                                <i class="fa fa-edit" style="margin-bottom: 2px;"></i>Sửa
                                                                phiếu
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- In --}}
                                            <div class="fade modal" id="printArea_{{ $item->code }}">
                                                <span class="link-primary position-absolute"
                                                    style="top: 5%; right: 4%;"><strong class="text-danger">Số đơn đặt
                                                        hàng:
                                                    </strong>{{ $item->code }}</span>
                                                <div class="modal-body bg-white mx-xl-18 pt-0 pb-15">
                                                    <div class="d-flex mb-5">
                                                        <img src="{{ asset('image/logo_warehouse.png') }}" width="100"
                                                            alt="">
                                                        <div class="text-left mt-3">
                                                            <h6 class="mb-0 pb-0">BỆNH VIỆN ĐA KHOA BEESOFT</h6>
                                                            <div>307C Nguyễn Văn Linh, An Khánh, Ninh Kiều, Cần Thơ
                                                            </div>
                                                            <div>Hotline: 0900900999</div>
                                                        </div>
                                                    </div>
                                                    <form action="" method="post">
                                                        <div class="text-center mb-7">
                                                            <h1 class="mb-3 text-uppercase text-primary">ĐƠN ĐẶT HÀNG
                                                            </h1>
                                                            <div class="text-muted fs-30">
                                                                Ngày lập
                                                                {{ \Carbon\Carbon::parse($item->request_date)->format('d-m-Y') }}
                                                            </div>
                                                        </div>
                                                        <div class="mb-15 text-left">
                                                            <!-- Begin::Receipt Info -->
                                                            <div class="mb-4">
                                                                <div class="pt-2">
                                                                    <h6><span id="modalSupplier"
                                                                            style="line-height: 1.6;">
                                                                            Công Ty <span
                                                                                class="text-success">BeeSoft</span>
                                                                            Có Nhu Cầu Đặt Mua Thiết Bị Tại
                                                                            <span
                                                                                class="text-danger">{{ !empty($item->supplier_code) ? $item->suppliers->name : '' }}</span>
                                                                            theo mẫu yêu
                                                                            cầu như sau:
                                                                        </span>
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                            <!-- End::Receipt Info -->

                                                            <!-- Begin::Receipt Items -->
                                                            <div class="mb-4 mt-3">
                                                                <div class="table-responsive rounded">
                                                                    <table
                                                                        class="table border border-dark align-middle gs-0 gy-4">
                                                                        <thead>
                                                                            <tr
                                                                                class="bg-success border border-dark text-center">
                                                                                <th style="width: 5%;"
                                                                                    class="ps-3 text-dark">
                                                                                    STT
                                                                                </th>
                                                                                <th style="width: 30%;" class="text-dark">
                                                                                    Thiết bị
                                                                                </th>
                                                                                <th style="width: 10%;" class="text-dark">
                                                                                    Đơn
                                                                                    vị
                                                                                </th>
                                                                                <th style="width: 15%;" class="text-dark">
                                                                                    Số
                                                                                    lượng
                                                                                </th>
                                                                                <th style="width: 20%;" class="text-dark">
                                                                                    Đơn
                                                                                    giá
                                                                                </th>
                                                                                <th class="pe-3 text-dark"
                                                                                    style="width: 20%;">
                                                                                    Thành tiền
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @php
                                                                                $totalMoneyIn = 0;
                                                                            @endphp
                                                                            @foreach ($item->import_equipment_request_details as $key => $detail_in)
                                                                                @php
                                                                                    $totalPrice =
                                                                                        $detail_in->quantity_quote *
                                                                                        $detail_in->price;
                                                                                    $totalWithDiscount =
                                                                                        $totalPrice *
                                                                                        (1 -
                                                                                            $detail_in->discount / 100);
                                                                                    $totalWithVat =
                                                                                        $totalWithDiscount *
                                                                                        (1 +
                                                                                            $detail_in->equipments
                                                                                                ->vat /
                                                                                                100);
                                                                                    $totalMoneyIn += $totalWithVat;
                                                                                @endphp
                                                                                <tr class="border border-dark">
                                                                                    <td class="text-right">
                                                                                        {{ $key + 1 }}
                                                                                    </td>
                                                                                    <td class="text-left">
                                                                                        {{ $detail_in->equipments->name }}
                                                                                    </td>
                                                                                    <td class="text-left">
                                                                                        {{ $detail_in->equipments->units->name }}
                                                                                    </td>
                                                                                    <td class="text-right">
                                                                                        {{ $detail_in->quantity_quote }}
                                                                                    </td>
                                                                                    <td class="text-right">
                                                                                        {{ number_format($detail_in->price, 0, ',', '.') }}
                                                                                        VND
                                                                                    </td>
                                                                                    <td class="text-right">
                                                                                        {{ number_format($totalWithVat, 0, ',', '.') }}
                                                                                        VND
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                            <tr class=" border border-dark">
                                                                                <td colspan="3" class="text-center">
                                                                                    Tổng cộng
                                                                                </td>
                                                                                <td colspan="3" class="text-center"
                                                                                    style="height: 30px; min-height: 30px;">
                                                                                    {{ number_format($totalMoneyIn, 0, ',', '.') }}
                                                                                    VND
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div>
                                                                    <div class="order-form">
                                                                        <p class="mb-0"><strong>Ghi Chú:</strong></p>
                                                                        <div class="dotted-line">{{ $item->note }}</div>

                                                                        <p class="mb-0"><strong>Thời gian giao
                                                                                hàng:</strong></p>
                                                                        <div class="dotted-line"></div>
                                                                        <div class="dotted-line"></div>

                                                                        <p class="mb-0"><strong>Phương thức thanh
                                                                                toán:</strong></p>
                                                                        <div class="dotted-line"></div>
                                                                        <div class="dotted-line"></div>
                                                                    </div>

                                                                    <style>
                                                                        .order-form {
                                                                            width: 100%;
                                                                            font-family: Arial, sans-serif;
                                                                        }

                                                                        .dotted-line {
                                                                            width: 100%;
                                                                            border-bottom: 1px dotted #000;
                                                                            margin-bottom: 15px;
                                                                            height: 20px;
                                                                        }
                                                                    </style>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-8"></div>
                                                                    <div class="col-4 mb-3">
                                                                        <p class="m-0 p-0">
                                                                            Cần Thơ, ngày
                                                                            {{ \Carbon\Carbon::now()->day }}
                                                                            tháng
                                                                            {{ \Carbon\Carbon::now()->month }} năm
                                                                            {{ \Carbon\Carbon::now()->year }}
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-1"></div>
                                                                    <div class="col-7">
                                                                        <p class="m-0 p-0">
                                                                            <strong>Người lập phiếu</strong>
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-4 text-center">
                                                                        <p class="m-0 p-0">
                                                                            <strong>Trưởng bộ phận</strong>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="noDataAlert">
                                    <td colspan="12" class="text-center">
                                        <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                                            role="alert"
                                            style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                            <div class="mb-3">
                                                <i class="fas fa-search" style="font-size: 36px; color: #6c757d;"></i>
                                            </div>
                                            <div class="text-center">
                                                <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Không Có Dữ
                                                    Liệu</h5>
                                                <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                    Không Có Dữ Liệu Nào Về Phiếu Yêu Cầu Mua Hàng
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($AllEquipmentRequest->count() > 0)
                <div class="card-body py-3 d-flex justify-content-between align-items-center">
                    <div class="dropdown d-none" id="action_delete_all">
                        <button class="btn btn-info btn-sm dropdown-toggle rounded-pill" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span>Chọn Thao Tác</span>
                        </button>
                        <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton1">
                            @if (session('isAdmin') == 1)
                                <li>
                                    <a class="dropdown-item pointer d-flex align-items-center" data-bs-toggle="modal"
                                        data-bs-target="#browseAll">
                                        <i class="fas fa-clipboard-check me-2 text-twitter"></i>
                                        <span>Duyệt phiếu</span>
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a class="dropdown-item pointer d-flex align-items-center" data-bs-toggle="modal"
                                    data-bs-target="#deleteAll">
                                    <i class="fas fa-trash me-2 text-danger"></i>
                                    <span class="text-danger">Hủy phiếu</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="DayNganCach"></div>
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center my-3">
                        <ul class="pagination pagination-sm custom-pagination">
                            {{ $AllEquipmentRequest->links('pagination::bootstrap-5') }}
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Modal Duyệt Tất Cả --}}
            <div class="modal fade" id="browseAll" tabindex="-1" aria-labelledby="browseAllModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title text-white" id="browseAllModal">Duyệt Yêu Cầu Mua Hàng</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-primary mb-4">Bạn có chắc chắn muốn duyệt tất cả yêu cầu mua hàng đã chọn?
                            </p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn rounded-pill btn-sm btn-secondary btn-sm px-4"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn rounded-pill btn-sm btn-twitter px-4 load_animation">
                                Duyệt</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Xác Nhận Hủy Tất Cả --}}
            <div class="modal fade" id="deleteAll" tabindex="-1" aria-labelledby="deleteAllLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title text-white" id="deleteAllLabel">Xác Nhận Hủy yêu cầu mua hàng</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-danger mb-4">Bạn có chắc chắn muốn hủy tất cả yêu cầu mua hàng đã chọn?</p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn rounded-pill btn-sm btn-secondary px-4"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn rounded-pill btn-sm btn-danger px-4 load_animation">Hủy
                                phiếu</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @foreach ($AllEquipmentRequest as $item)
        <!-- Modal Từ Chối Duyệt Yêu Cầu Mua Hàng -->
        <div class="modal fade" id="noBrowse_{{ $item->code }}" tabindex="-1" aria-labelledby="checkModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white" id="checkModalLabel">Từ Chối Yêu Cầu Mua Hàng</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('equipment_request.import') }}" id="form_refuse" method="POST">
                        @csrf
                        <input type="hidden" name="no_browse_request" value="{{ $item->code }}">
                        <div class="modal-body pb-0">
                            <select name="reason_refuse" id="reason_refuse"
                                class="form-select form-select-sm rounded-pill">
                                <option value="">-- Chọn lý do từ chối --</option>
                                <option value="Không cần thiết">Không cần thiết</option>
                                <option value="Ngân sách không đủ">Ngân sách không đủ</option>
                                <option value="Yêu cầu không hợp lệ">Yêu cầu không hợp lệ</option>
                                <option value="Chưa được cấp trên phê duyệt">Chưa được cấp trên phê duyệt</option>
                                <option value="Nhà cung cấp không phù hợp">Nhà cung cấp không phù hợp</option>
                                <option value="Thời điểm không phù hợp">Thời điểm không phù hợp</option>
                                <option value="Lỗi hệ thống hoặc yêu cầu trùng lặp">Lỗi hệ thống hoặc yêu cầu trùng lặp
                                </option>
                                <option value="Không đáp ứng quy định hoặc chính sách">Không đáp ứng quy định hoặc chính
                                    sách</option>
                                <option value="other">Khác</option>
                            </select>
                            <span id="reason_refuse_error" class="message_error pt-2 ps-2 d-none">Vui lòng chọn lý do từ
                                chối.</span>

                            <input type="text" name="reason_refuse_other" id="other_reason_refuse"
                                class="form-control form-control-sm rounded-pill mt-3 d-none"
                                placeholder="Nhập lý do từ chối..">
                            <span id="other_reason_refuse_error" class="message_error pt-2 ps-2 d-none">Vui lòng nhập lý
                                do</span>

                            <input type="hidden" name="user_request"
                                value="{{ $item->users->last_name . ' ' . $item->users->first_name }}">

                            <input type="hidden" name="email_user_request" value="{{ $item->users->email }}">
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn rounded-pill btn-sm btn-secondary px-4"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn rounded-pill btn-sm btn-danger px-4"
                                id="refuseForm">Gửi</button>
                        </div>

                        <script>
                            const reasonRefuseSelect = document.getElementById('reason_refuse');
                            const otherReasonInput = document.getElementById('other_reason_refuse');
                            const reasonRefuseError = document.getElementById('reason_refuse_error');
                            const otherReasonError = document.getElementById('other_reason_refuse_error');
                            const refuseForm = document.getElementById('refuseForm');
                            const form_refuse = document.getElementById('form_refuse');

                            reasonRefuseSelect.addEventListener('change', function() {
                                if (this.value === 'other') {
                                    otherReasonInput.classList.remove('d-none');
                                } else {
                                    otherReasonInput.classList.add('d-none');
                                    otherReasonInput.value = '';
                                }

                                reasonRefuseError.classList.add('d-none');
                                otherReasonError.classList.add('d-none');
                            });

                            refuseForm.addEventListener('click', function(event) {
                                event.preventDefault();

                                document.getElementById('loading').style.display = 'block';
                                document.getElementById('loading-overlay').style.display = 'block';
                                this.disabled = true;

                                setTimeout(() => {
                                    let isValid = true;

                                    if (reasonRefuseSelect.value === '') {
                                        reasonRefuseError.classList.remove('d-none');
                                        isValid = false;
                                    }

                                    if (reasonRefuseSelect.value === 'other' && otherReasonInput.value.trim() === '') {
                                        otherReasonError.classList.remove('d-none');
                                        isValid = false;
                                    }

                                    if (isValid) {
                                        form_refuse.submit();
                                    }

                                    document.getElementById('loading').style.display = 'none';
                                    document.getElementById('loading-overlay').style.display = 'none';
                                    this.disabled = false;
                                }, 1000);
                            });
                        </script>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Xem Lý Do Từ Chối -->
        <div class="modal fade" id="detail_reason_{{ $item->code }}" tabindex="-1" aria-labelledby="checkModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title text-white" id="checkModalLabel">Lý do từ chối</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center pb-0">
                        <h6 class="text-dark">
                            {{ $item->reason_refuse }}
                        </h6>
                    </div>
                    <div class="modal-footer justify-content-center border-0">
                        <button type="button" class="btn rounded-pill btn-sm btn-secondary px-4"
                            data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Duyệt Yêu Cầu Mua Hàng -->
        <div class="modal fade" id="browse_{{ $item->code }}" tabindex="-1" aria-labelledby="checkModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title text-white" id="checkModalLabel">Duyệt
                            Yêu Cầu Mua Hàng</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('equipment_request.import') }}" id="form-3" method="POST">
                        @csrf
                        <input type="hidden" name="browse_request" value="{{ $item->code }}">
                        <div class="modal-body text-center pb-0">
                            <p class="text-dark mb-4">Bạn có chắc chắn muốn duyệt yêu cầu mua hàng này?
                            </p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn rounded-pill btn-sm btn-secondary px-4"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn rounded-pill btn-sm btn-success px-4 load_animation">Duyệt
                                phiếu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Hủy --}}
        <div class="modal fade" id="deleteModal_{{ $item->code }}" tabindex="-1" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white" id="deleteModalLabel">Hủy Yêu Cầu Mua Hàng
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('equipment_request.import') }}" id="form-4" method="POST">
                        @csrf
                        <input type="hidden" name="delete_request" value="{{ $item->code }}">
                        <div class="modal-body pb-0 text-center">
                            <p class="text-danger mb-4">Bạn có chắc chắn muốn hủy yêu cầu mua hàng này?</p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn rounded-pill btn-sm btn-secondary px-4"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn rounded-pill btn-sm btn-danger px-4 load_animation">Hủy
                                phiếu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Lưu phiếu --}}
        <div class="modal fade" id="save_{{ $item->code }}" tabindex="-1" aria-labelledby="saveModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="saveModalLabel">
                            Tạo Phiếu Yêu Cầu Mua Hàng
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('equipment_request.import') }}" id="form-4" method="POST">
                        @csrf
                        <input type="hidden" name="save_status" value="{{ $item->code }}">
                        <div class="modal-body pb-0 text-center">
                            <p class="text-primary mb-4">
                                Tạo Phiếu Yêu Cầu Mua Hàng Này?
                            </p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn rounded-pill btn-sm btn-secondary px-4"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit"
                                class="btn rounded-pill btn-sm btn-twitter px-4 load_animation">Tạo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
