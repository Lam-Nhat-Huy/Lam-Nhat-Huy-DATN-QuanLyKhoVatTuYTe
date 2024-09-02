@extends('master_layout.layout')

@section('styles')
    <style>
        .autocomplete-items {
            position: absolute;
            border: 1px solid #ced4da;
            background-color: #ffffff;
            z-index: 99;
            top: 100%;
            left: 0;
            right: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 0.375rem;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            font-size: 14px;
            background-color: #ffffff;
            border-bottom: 1px solid #f1f3f5;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .autocomplete-items div:hover {
            background-color: #5b6a7b;
            color: #ffffff;
        }

        .autocomplete-items .autocomplete-active {
            background-color: #5b6a7b;
            color: #ffffff;
        }
    </style>
@endsection

@section('title')
    Nhập Kho
@endsection

@section('content')
    <form action="{{ route('warehouse.store_import') }}" method="POST">
        @csrf
        <div class="card pb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Tạo Phiếu Nhập Kho</span>
                </h3>
                <div class="card-toolbar">
                    <a href="{{ route('warehouse.import') }}" class="btn btn-sm btn-dark">
                        <span class="align-items-center d-flex">
                            <i class="fa fa-arrow-left me-1"></i>
                            Trở Lại
                        </span>
                    </a>
                </div>
            </div>

            <div class="py-5 px-lg-17">

                <div class="me-n7 pe-7">

                    <div class="row mb-5">
                        <div class="col-6 mb-4">
                            <label for="supplier_id" class="required form-label mb-2">Nhà cung cấp</label>
                            <select class="form-select form-select-sm form-select-solid border border-success setupSelect2"
                                id="supplier_id" name="supplier_id">
                                <option value="">--Chọn nhà cung cấp--</option>
                                <option value="supplier1">Nhà cung cấp 1</option>
                                <option value="supplier2">Nhà cung cấp 2</option>
                            </select>
                        </div>

                        <div class="col-6 mb-4">
                            <label for="receipt_date" class="required form-label mb-2">Ngày nhập</label>
                            <input type="date"
                                class="form-control form-control-sm form-control-solid border border-success"
                                id="receipt_date" name="receipt_date">
                        </div>

                        <div class="col-6 mb-4">
                            <label for="invoice_number" class="required form-label mb-2">Số hóa đơn</label>
                            <input type="number"
                                class="form-control form-control-sm form-control-solid border border-success"
                                id="invoice_number" name="invoice_number" placeholder="Nhập Số Hóa Đơn...">
                        </div>

                        <div class="col-6 mb-4">
                            <label for="invoice_symbol" class="required form-label mb-2">Kí hiệu hóa đơn</label>
                            <input type="number"
                                class="form-control form-control-sm form-control-solid border border-success"
                                id="invoice_symbol" name="invoice_symbol" placeholder="Nhập Kí Hiệu Hóa Đơn...">
                        </div>

                        <div class="col-12">
                            <label for="note" class="form-label mb-2">Ghi chú</label>
                            <textarea class="form-control form-control-sm form-control-solid border border-success" id="note" name="note"
                                rows="3" placeholder="Nhập ghi chú"></textarea>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="card py-5 mb-xl-8">
            <div class="py-5 px-lg-17">
                <div class="me-n7 pe-7">
                    <div class="mb-5">
                        <div class="row mb-3">
                            <div class="col-6 mb-4">
                                <label for="material_id" class="required form-label mb-2">Tên vật tư</label>
                                <select
                                    class="form-select form-select-sm form-select-solid border border-success setupSelect2"
                                    id="material_id" name="material_id">
                                    <option value="">--Chọn Vật Tư--</option>
                                    <option value="">Vật Tư 1</option>
                                    <option value="">Vật Tư 2</option>
                                </select>
                            </div>

                            <div class="col-6 mb-4">
                                <label for="unit_price" class="required form-label mb-2">Giá nhập</label>
                                <input type="text"
                                    class="form-control form-control-sm form-control-solid border border-success"
                                    id="unit_price" name="unit_price" placeholder="Nhập đơn giá">
                            </div>

                            <div class="col-6 mb-4">
                                <label for="quantity" class="required form-label mb-2">Số lượng</label>
                                <input type="number"
                                    class="form-control form-control-sm form-control-solid border border-success"
                                    id="quantity" name="quantity" placeholder="Nhập số lượng">
                            </div>

                            <div class="col-6 mb-4">
                                <label for="discount_rate" class="required form-label mb-2">Chiết khấu (%)</label>
                                <input type="text"
                                    class="form-control form-control-sm form-control-solid border border-success"
                                    id="discount_rate" name="discount_rate" placeholder="Nhập chiết khấu (%)">
                            </div>

                            <div class="col-6 mb-4">
                                <label for="vat_rate" class="required form-label mb-2">VAT (%)</label>
                                <input type="text"
                                    class="form-control form-control-sm form-control-solid border border-success"
                                    id="vat_rate" name="vat_rate" placeholder="Nhập VAT (%)">
                            </div>


                            <div class="col-6 mb-4">
                                <label for="batch_number" class="required form-label mb-2">Số lô</label>
                                <input type="text"
                                    class="form-control form-control-sm form-control-solid border border-success"
                                    id="batch_number" name="batch_number" placeholder="Nhập số lô">
                            </div>

                            <div class="col-6 mb-4">
                                <label for="product_date" class="required form-label mb-2">Ngày sản xuất</label>
                                <input type="date"
                                    class="form-control form-control-sm form-control-solid border border-success"
                                    id="product_date" name="product_date">
                            </div>

                            <div class="col-6 mb-4">
                                <label for="expiry_date" class="form-label mb-2">Hạn sử dụng</label>
                                <input type="date"
                                    class="form-control form-control-sm form-control-solid border border-success"
                                    id="expiry_date" name="expiry_date">
                            </div>
                        </div>

                    </div>

                    <div id="materials-hidden-inputs"></div>

                    <div class="text-end mb-4">
                        <button type="button" id="add-material" class="btn btn-success btn-sm me-2">Thêm Sản
                            Phẩm</button>
                    </div>

                    <div class="card p-4 mb-4 col-md-12">
                        <div class="row">
                            <div class="col-md-9 ps-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover text-center">
                                        <thead class="fw-bolder bg-success">
                                            <tr>
                                                <th class="ps-4">Tên</th>
                                                <th class="">Số lượng</th>
                                                <th class="">Giá nhập</th>
                                                <th class="">Tổng cộng</th>
                                                <th class="">Số lô</th>
                                                <th class="">Hạn dùng</th>
                                                <th class="">CK (%)</th>
                                                <th class="">VAT (%)</th>
                                                <th class="">TT trước VAT</th>
                                                <th class="">Thành tiền</th>
                                                <th class="pe-3">ACT</th>
                                            </tr>
                                        </thead>
                                        <tbody id="materials-list">
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Total Price Summary -->
                            <div class="col-md-3 pe-0">
                                <div class="card p-5" style="background: #e1e9f4">
                                    <h5 class="card-title">Tổng Cộng</h5>
                                    <hr>
                                    <p class="mb-1">Tổng Tiền Hàng:
                                        <span class="fw-bold">
                                            10,000,000 <!-- Giá trị cứng -->
                                        </span>
                                    </p>
                                    <p class="mb-1">Tổng Chiết Khấu:
                                        <span class="fw-bold">
                                            500,000 <!-- Giá trị cứng -->
                                        </span>
                                    </p>
                                    <p class="mb-1">Tổng VAT:
                                        <span class="fw-bold">
                                            1,000,000 <!-- Giá trị cứng -->
                                        </span>
                                    </p>
                                    <hr>
                                    <p class="fs-4 fw-bold mb-0">Tổng:
                                        10,500,000 <!-- Giá trị cứng -->
                                    </p>
                                    <hr>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer flex-right pe-0">
                        <button type="submit" class="btn btn-twitter btn-sm">
                            Tạo Phiếu Nhập
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection

@section('scripts')
    <script>
        const materials = @json($receiptItems);
        const addedMaterials = [];
        const materialsList = document.getElementById('materials-list');
        const materialsHiddenInputs = document.getElementById('materials-hidden-inputs');
        const selectedMaterialDiv = document.getElementById('selected-material');
        const materialInput = document.getElementById('material');
        let selectedMaterial = null;


        function autocomplete(input, items) {
            let currentFocus;
            input.addEventListener("input", function(e) {
                let list, item, i, val = this.value;
                closeAllLists();
                if (!val) return false;
                currentFocus = -1;
                list = document.createElement("DIV");
                list.setAttribute("id", this.id + "-autocomplete-list");
                list.setAttribute("class", "autocomplete-items");
                this.parentNode.appendChild(list);
                for (i = 0; i < items.length; i++) {
                    if (items[i].name.toLowerCase().includes(val.toLowerCase())) {
                        item = document.createElement("DIV");
                        item.innerHTML = "<strong>" + items[i].name.substr(0, val.length) + "</strong>";
                        item.innerHTML += items[i].name.substr(val.length);
                        item.innerHTML += " - Qty: " + items[i].quantity;
                        item.innerHTML += "<input type='hidden' value='" + items[i].name + "'>";
                        item.addEventListener("click", function(e) {
                            input.value = this.getElementsByTagName("input")[0].value;
                            fillMaterialDetails(this.getElementsByTagName("input")[0].value);
                            closeAllLists();
                        });
                        list.appendChild(item);
                    }
                }
            });

            input.addEventListener("keydown", function(e) {
                let x = document.getElementById(this.id + "-autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    currentFocus++;
                    addActive(x);
                } else if (e.keyCode == 38) {
                    currentFocus--;
                    addActive(x);
                } else if (e.keyCode == 13) {
                    e.preventDefault();
                    if (currentFocus > -1) {
                        if (x) x[currentFocus].click();
                    }
                }
            });

            function addActive(x) {
                if (!x) return false;
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                x[currentFocus].classList.add("autocomplete-active");
            }

            function removeActive(x) {
                for (let i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }

            function closeAllLists(elmnt) {
                let x = document.getElementsByClassName("autocomplete-items");
                for (let i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != input) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }

            document.addEventListener("click", function(e) {
                closeAllLists(e.target);
            });
        }

        function fillMaterialDetails(materialName) {
            const material = materials.find(mat => mat.name === materialName);
            if (material) {
                document.getElementById('unit_price').value = material.unit_price;
                document.getElementById('batch_number').value = material.batch_number;
                document.getElementById('expiry_date').value = material.expiry_date;
                document.getElementById('discount_rate').value = material.discount_rate;
                document.getElementById('vat_rate').value = material.vat_rate;
                document.getElementById('quantity').value = material.quantity;
                document.getElementById('product_date').value = material.product_date;

                // Set unit in the select dropdown
                const unitSelect = document.getElementById('unit');
                const options = unitSelect.options;
                for (let i = 0; i < options.length; i++) {
                    if (options[i].text === material.unit) {
                        unitSelect.selectedIndex = i;
                        break;
                    }
                }
            }
        }

        // Thêm vật tư vào danh sách
        document.getElementById('add-material').addEventListener('click', function() {
            const material_id = document.getElementById('material_id').value; // Em mới đổi qua option
            const unit_price = parseFloat(document.getElementById('unit_price').value) || 0;
            const quantity = parseFloat(document.getElementById('quantity').value) || 0;
            const discount_rate = parseFloat(document.getElementById('discount_rate').value) || 0;
            const vat_rate = parseFloat(document.getElementById('vat_rate').value) || 0;
            const batch_number = document.getElementById('batch_number').value;
            const expiry_date = document.getElementById('expiry_date').value;

            // Tính toán chiết khấu và VAT
            const discountAmount = (unit_price * quantity) * (discount_rate / 100);
            const totalBeforeVAT = (unit_price * quantity) - discountAmount;
            const totalPrice = totalBeforeVAT + (totalBeforeVAT * vat_rate / 100);

            // Tạo hàng mới cho bảng
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${material_id}</td>
                <td>${quantity}</td>
                <td>${unit_price}</td>
                <td>${quantity * unit_price}</td>
                <td>${batch_number}</td>
                <td>${expiry_date}</td>
                <td>${discount_rate}</td>
                <td>${vat_rate}</td>
                <td>${totalBeforeVAT}</td>
                <td>${totalPrice}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-material">Xóa</button>
                </td>
            `;
            materialsList.appendChild(tr);

            // Tạo input ẩn để gửi dữ liệu
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'materials[]';
            hiddenInput.value = JSON.stringify({
                material_id,
                quantity,
                unit_price,
                discount_rate,
                vat_rate,
                batch_number,
                expiry_date
            });
            materialsHiddenInputs.appendChild(hiddenInput);

            // Thêm sự kiện xóa cho nút xóa
            tr.querySelector('.remove-material').addEventListener('click', function() {
                tr.remove(); // Xóa hàng khỏi bảng
                hiddenInput.remove(); // Xóa input ẩn khỏi danh sách
            });

            // Xóa các ô nhập liệu sau khi thêm vào danh sách
            document.getElementById('material_id').value = '';
            document.getElementById('unit_price').value = '';
            document.getElementById('quantity').value = '';
            document.getElementById('discount_rate').value = '';
            document.getElementById('vat_rate').value = '';
            document.getElementById('batch_number').value = '';
            document.getElementById('expiry_date').value = '';
        });


        document.addEventListener('DOMContentLoaded', function() {
            autocomplete(document.getElementById("material_id"), materials);

            document.querySelector('button[type="submit"]').addEventListener('click', function() {
                addMaterial();
            });
        });
    </script>
@endsection
