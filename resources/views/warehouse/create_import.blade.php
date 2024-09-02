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

@section('content')
    <div class="card mb-5 mb-xl-8" style="background-color: #e1e9f4">

        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Tạo Phiếu Nhập</span>
            </h3>

            <a href="{{ route('warehouse.export') }}" class="fw-bold text-dark">Quay về</a>
        </div>

        <div class="card-body">
            <form action="{{ route('warehouse.store_import') }}" method="POST">
                @csrf

                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="supplier_id" class="form-label mb-2">Nhà cung cấp</label>
                            <select class="form-select setupSelect2" id="supplier_id" name="supplier_id">
                                <option value="">Chọn nhà cung cấp</option>
                                <option value="supplier1">Nhà cung cấp 1</option>
                                <option value="supplier2">Nhà cung cấp 2</option>
                            </select>
                        </div>


                        <div class="col-md-4">
                            <label for="created_by" class="form-label mb-2">Người tạo</label>
                            <select class="form-select setupSelect2" id="created_by" name="created_by">
                                <option value="">Chọn người tạo</option>
                                <option value="user1">Người tạo 1</option>
                                <option value="user2">Người tạo 2</option>
                            </select>
                        </div>


                        <div class="col-md-4">
                            <label for="receipt_date" class="form-label mb-2">Ngày nhập</label>
                            <input type="date" class="form-control" id="receipt_date" name="receipt_date">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="invoice_number" class="form-label mb-2">Số hóa đơn</label>
                            <input type="number" class="form-control" id="invoice_number" name="invoice_number">
                        </div>

                        <div class="col-md-6">
                            <label for="invoice_symbol" class="form-label mb-2">Kí hiệu hóa đơn</label>
                            <input type="number" class="form-control" id="invoice_symbol" name="invoice_symbol">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="note" class="form-label mb-2">Ghi chú</label>
                            <textarea class="form-control" id="note" name="note" rows="3" placeholder="Nhập ghi chú"></textarea>
                        </div>
                    </div>
                </div>

                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="material_id" class="form-label mb-2">Tên vật tư</label>
                            <input type="text" class="form-control" id="material_id" name="material_id"
                                placeholder="Nhập tên vật tư">
                            <div id="autocomplete-list" class="autocomplete-items"></div>
                        </div>



                        <div class="col-md-6">
                            <label for="unit_price" class="form-label mb-2">Giá nhập</label>
                            <input type="text" class="form-control" id="unit_price" name="unit_price"
                                placeholder="Nhập đơn giá">
                        </div>
                    </div>

                    <div class="row mb-3">


                        <div class="col-md-6">
                            <label for="quantity" class="form-label mb-2">Số lượng</label>
                            <input type="number" class="form-control" id="quantity" name="quantity"
                                placeholder="Nhập số lượng">
                        </div>

                        <div class="col-md-6">
                            <label for="discount_rate" class="form-label mb-2">Chiết khấu (%)</label>
                            <input type="text" class="form-control" id="discount_rate" name="discount_rate"
                                placeholder="Nhập chiết khấu (%)">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="vat_rate" class="form-label mb-2">VAT (%)</label>
                            <input type="text" class="form-control" id="vat_rate" name="vat_rate"
                                placeholder="Nhập VAT (%)">
                        </div>


                        <div class="col-md-6">
                            <label for="batch_number" class="form-label mb-2">Số lô</label>
                            <input type="text" class="form-control" id="batch_number" name="batch_number"
                                placeholder="Nhập số lô">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="product_date" class="form-label mb-2">Ngày sản xuất</label>
                            <input type="date" class="form-control" id="product_date" name="product_date">
                        </div>

                        <div class="col-md-6">
                            <label for="expiry_date" class="form-label mb-2">Hạn sử dụng</label>
                            <input type="date" class="form-control" id="expiry_date" name="expiry_date">
                        </div>
                    </div>

                </div>

                <div id="materials-hidden-inputs"></div>

                <!-- Submit Button -->
                <div class="text-end mb-4">
                    <button type="button" id="add-material" class="btn btn-success btn-sm">Thêm sản phẩm</button>

                    <button type="submit" class="btn btn-danger btn-sm">Tạo phiếu nhập</button>
                </div>


                <!-- Block 3: Receipt Items List -->
                <div class="card p-4 mb-4 col-md-12">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">Tên</th>
                                            <th scope="col">Số lượng</th>
                                            <th scope="col">Giá nhập</th>
                                            <th scope="col">Tổng cộng</th>
                                            <th scope="col">Số lô</th>
                                            <th scope="col">Hạn dùng</th>
                                            <th scope="col">CK (%)</th>
                                            <th scope="col">VAT (%)</th>
                                            <th scope="col">TT trước VAT</th>
                                            <th scope="col">Thành tiền</th>
                                            <th scope="col">ACT</th>
                                        </tr>
                                    </thead>
                                    <tbody id="materials-list">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Total Price Summary -->
                        <div class="col-md-3">
                            <div class="card p-3" style="background: #e1e9f4">
                                <h5 class="card-title">Tổng kết</h5>
                                <hr>
                                <p class="mb-1">Tổng tiền hàng:
                                    <span class="fw-bold">
                                        10,000,000 <!-- Giá trị cứng -->
                                    </span>
                                </p>
                                <p class="mb-1">Tổng chiết khấu:
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
                                <p class="fs-4 fw-bold">Tổng giá:
                                    10,500,000 <!-- Giá trị cứng -->
                                </p>
                                <hr>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
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
            const material_id = document.getElementById('material_id').value;
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
