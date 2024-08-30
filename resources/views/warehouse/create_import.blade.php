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
        </div>

        <div class="card-body">
            <form action="" method="POST">
                @csrf
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="supplier_id" class="form-label mb-2">Nhà cung cấp</label>
                            <select class="form-select" id="supplier_id" name="supplier_id">
                                <option value="">Chọn nhà cung cấp</option>
                                <option value="supplier1">Nhà cung cấp 1</option>
                                <option value="supplier2">Nhà cung cấp 2</option>
                            </select>
                        </div>


                        <div class="col-md-4">
                            <label for="created_by" class="form-label mb-2">Người tạo</label>
                            <select class="form-select" id="created_by" name="created_by">
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
                        <div class="col-md-4">
                            <label for="product_date" class="form-label mb-2">Ngày sản xuất</label>
                            <input type="date" class="form-control" id="product_date" name="product_date">
                        </div>

                        <div class="col-md-4">
                            <label for="expiry_date" class="form-label mb-2">Hạn sử dụng</label>
                            <input type="date" class="form-control" id="expiry_date" name="expiry_date">
                        </div>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="text-end mb-4">
                    <button type="submit" class="btn btn-success btn-sm">Thêm sản phẩm</button>
                </div>
            </form>

            <form action="" action="POST">
                @csrf
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
                                    <tbody>
                                        <tr>
                                            <td>Vật liệu A</td>
                                            <td>10</td>
                                            <td>{{ number_format(20000, 0, ',', '.') }}</td>
                                            <td>{{ number_format(20000, 0, ',', '.') }}</td>
                                            <td>125</td>
                                            <td>2025</td>
                                            <td>5%</td>
                                            <td>10%</td>
                                            <td>{{ number_format(18000, 0, ',', '.') }}</td>
                                            <td>{{ number_format(19000, 0, ',', '.') }}</td>
                                            <td>
                                                <div class="d-flex justify-content-end flex-shrink-0">

                                                    <a href="#"
                                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <path
                                                                    d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                    fill="black"></path>
                                                                <path opacity="0.5"
                                                                    d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                    fill="black"></path>
                                                                <path opacity="0.5"
                                                                    d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                    fill="black"></path>
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
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
                                <button class="btn btn-primary btn-sm w-100 mt-3" id="saveReceipt">Lưu phiếu nhập</button>
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

        document.addEventListener('DOMContentLoaded', function() {
            autocomplete(document.getElementById("material_id"), materials);
        });
    </script>
@endsection
