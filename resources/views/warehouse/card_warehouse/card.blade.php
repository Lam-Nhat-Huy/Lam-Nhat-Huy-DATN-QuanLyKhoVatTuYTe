@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8 shadow">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh sách lô</span>
            </h3>
        </div>

        @include('warehouse.card_warehouse.filter')

        <div class="card-body py-3 pb-10">
            <div class="table-responsive rounded">
                <table class="table align-middle gs-0 gy-4">
                    <thead class="bg-success">
                        <tr class="fw-bolder">
                            <th class="ps-3" style="width: 40%;">Thiết Bị</th>
                            <th style="width: 20%;">Tồn Đầu</th>
                            <th style="width: 20%; white-space: nowrap;">Tồn Cuối</th>
                            <th class="pe-3 text-center" style="width: 20%;">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="noDataAlert">
                            <td colspan="12" class="text-center">
                                <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                                    role="alert"
                                    style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                    <div class="mb-3">
                                        <i class="fas fa-clipboard-check" style="font-size: 36px; color: #6c757d;"></i>
                                    </div>
                                    <div class="text-center">
                                        <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Thông tin thiết
                                            bị
                                            trống</h5>
                                        <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                            Hãy chọn thiết bị để xem thông tin thẻ kho.
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
