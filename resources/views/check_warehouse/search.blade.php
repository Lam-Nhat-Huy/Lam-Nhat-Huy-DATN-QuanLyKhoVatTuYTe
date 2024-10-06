@forelse ($inventoryChecks as $item)
    <tr class="text-center hover-table pointer" data-bs-toggle="collapse" data-bs-target="#collapse{{ $item['code'] }}"
        aria-expanded="false" aria-controls="collapse{{ $item['code'] }}">
        <td>
            <input type="checkbox" class="row-checkbox" />
        </td>
        <td>
            {{ $item['code'] }}
        </td>
        <td>
            {{ $item['check_date'] }}
        </td>
        <td>
            -8
        </td>
        <td>
            0
        </td>
        <td>
            -8
        </td>
        <td>
            @if ($item['status'] == 0)
                <span class="label label-temp text-danger">Phiếu tạm</span>
            @else
                <span class="label label-final text-success">Đã cân bằng</span>
            @endif
        </td>
    </tr>

    <!-- Collapse content -->
    <tr class="collapse multi-collapse" id="collapse{{ $item['code'] }}">
        <td class="p-0" colspan="12"
            style="border: 1px solid #dcdcdc; background-color: #fafafa; padding-top: 0 !important;">
            <div class="flex-lg-row-fluid border-2 border-lg-1">
                <div class="card card-flush p-2 mb-3"
                    style="padding-top: 0px !important; padding-bottom: 0px !important;">
                    <div class="card-header d-flex justify-content-between align-items-center p-2"
                        style="padding-top: 0 !important; padding-bottom: 0px !important;">
                        <h4 class="fw-bold m-0">Chi tiết phiếu kiểm kho</h4>
                    </div>
                    <div class="card-body p-2" style="padding-top: 0px !important">
                        <div class="row py-5" style="padding-top: 0px !important">
                            <!-- Begin::Receipt Info (Left column) -->
                            <div class="col-md-4">
                                <table class="table table-flush gy-1">
                                    <tbody>
                                        <tr>
                                            <td class=""><strong>Mã kiểm kho</strong>
                                            </td>

                                            <td class="text-gray-800">
                                                {{ $item['code'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class=""><strong>Thời gian</strong>
                                            </td>
                                            <td class="text-gray-800">
                                                {{ $item['created_at'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class=""><strong>Ngày cân bằng</strong>
                                            </td>
                                            <td class="text-gray-800">
                                                {{ $item['check_date'] }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class=""><strong>Ghi chú</strong>
                                            </td>
                                            <td class="text-gray-800">
                                                {{ $item['note'] }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- End::Receipt Info -->

                            <div class="col-md-4">
                                <table class="table table-flush gy-1">
                                    <tbody>
                                        <tr>
                                            <td class=""><strong>Trạng thái</strong></td>
                                            <td class="text-gray-800">
                                                @if ($item['status'] == 0)
                                                    <span class="text-danger">Phiếu tạm</span>
                                                @else
                                                    <span class="text-success">Đã cân bằng </span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class=""><strong>Tài khoản tạo</strong>
                                            </td>
                                            <td class="text-gray-800">
                                                {{ $item['user_code'] }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- End::Receipt Info -->
                        </div>

                        <!-- Begin::Receipt Items (Right column) -->
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-hover">
                                    <thead class=" bg-danger">
                                        <tr>
                                            <th class="ps-3">Mã thiết bị</th>
                                            <th>Tên thiết bị</th>
                                            <th>Tồn kho</th>
                                            <th>Số lượng thực tế</th>
                                            <th>Số lượng lệch</th>
                                            <th class="pe-3">Giá trị lệch</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($item['details'] as $detail)
                                            <tr class="text-center">
                                                <td class="ps-4">
                                                    {{ $detail['equipment_code'] }}
                                                </td>
                                                <td>Băng gạc</td>
                                                <td>
                                                    {{ $detail['current_quantity'] }}
                                                </td>
                                                <td>
                                                    {{ $detail['actual_quantity'] }}
                                                </td>
                                                <td>
                                                    {{ $detail['unequal'] }}
                                                </td>
                                                <td>
                                                    190.000 đ
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End::Receipt Items -->
                    </div>
                </div>

                <div class="card-body py-3 text-end">
                    <div class="button-group">
                        <!-- Nút Duyệt đơn, chỉ hiển thị khi là Phiếu Tạm -->
                        @if (true)
                            <button style="font-size: 10px;" class="btn btn-sm btn-success me-2" data-bs-toggle="modal"
                                data-bs-target="#browse-}" type="button">
                                <i style="font-size: 10px;" class="fas fa-clipboard-check"></i>Duyệt
                                Phiếu
                            </button>
                        @endif

                        <!-- Nút Sửa đơn -->
                        @if (true)
                            <a style="font-size: 10px;" href="" class="btn btn-dark btn-sm me-2"><i
                                    style="font-size: 10px;" class="fa fa-edit"></i>Sửa Phiếu</a>
                        @endif
                        @if (true)
                            <!-- Nút In Phiếu -->
                            <button style="font-size: 10px;" class="btn btn-sm btn-twitter me-2" id="printPdfBtn"
                                type="button">
                                <i style="font-size: 10px;" class="fa fa-print"></i>In Phiếu
                            </button>
                        @endif

                        @if (true)
                            <!-- Nút xóa, có thể nằm trong danh sách hoặc bảng -->
                            <button style="font-size: 10px;" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#delete-">
                                <i style="font-size: 10px;" class="fa fa-trash"></i>Xóa phiếu
                            </button>
                        @endif


                    </div>
                </div>
            </div>
        </td>
    </tr>

    {{-- <!-- Modal Duyệt Phiếu -->
<div class="modal fade" id="browse-{{ $item->code }}" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="browseLabel-{{ $item->code }}"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title text-white" id="browseLabel-{{ $item->code }}">Duyệt
                    Phiếu Nhập Kho</h5>
                <button type="button" class="btn-close btn-close-white"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" style="padding-bottom: 0px;">
                <form action="{{ route('receipts.approve', $item->code) }}" method="POST"
                    id="approveForm-{{ $item->code }}">
                    @csrf
                    <p class="text-danger mb-4">Bạn có chắc chắn muốn duyệt phiếu nhập kho này?
                    </p>
                </form>
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-sm btn-secondary px-4"
                    data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-sm btn-success px-4"
                    onclick="event.preventDefault(); document.getElementById('approveForm-{{ $item->code }}').submit();">
                    Duyệt
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xóa Phiếu -->
<div class="modal fade" id="delete-{{ $item->code }}" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="deleteLabel-{{ $item->code }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white" id="deleteLabel-{{ $item->code }}">Xác
                    Nhận Xóa Phiếu</h5>
                <button type="button" class="btn-close btn-close-white"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" style="padding-bottom: 0px;">
                <form action="{{ route('receipts.delete', $item->code) }}" method="POST"
                    id="deleteForm-{{ $item->code }}">
                    @csrf
                    <p class="text-danger mb-4">Bạn có chắc chắn muốn xóa phiếu này?</p>
                </form>
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-sm btn-secondary px-4"
                    data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-sm btn-danger px-4"
                    onclick="event.preventDefault(); document.getElementById('deleteForm-{{ $item->code }}').submit();">
                    Xóa
                </button>
            </div>
        </div>
    </div>
</div> --}}


@empty
    <tr id="noDataAlert">
        <td colspan="12" class="text-center">
            <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                role="alert" style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                <div class="mb-3">
                    <i class="fas fa-search" style="font-size: 36px; color: #6c757d;"></i>
                </div>
                <div class="text-center">
                    <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Không có kết quả tìm kiếm</h5>
                    <p style="font-size: 14px; color: #6c757d; margin: 0;">
                        Không tìm thấy kết quả phù hợp với yêu cầu tìm kiếm của bạn. Vui lòng thử lại với từ khóa khác.
                    </p>
                </div>
            </div>
        </td>
    </tr>
@endforelse
