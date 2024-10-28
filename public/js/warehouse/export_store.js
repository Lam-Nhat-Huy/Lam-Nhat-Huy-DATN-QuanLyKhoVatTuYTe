$(document).ready(function () {
    let equipmentName;
    let equipmentQuantities = {}; // Lưu trữ số lượng đã thêm cho từng thiết bị
    let inventoryState = {};
    $('#material_code').on('change', function () {
        const equipmentCode = $(this).val();
        const batchInfoContainer = $('#batch_info');
        batchInfoContainer.html('');

        if (equipmentCode) {
            $.ajax({
                url: postExportUrl,
                method: 'POST',
                data: {
                    _token: csrfToken,
                    equipment_code: equipmentCode
                },
                success: function (response) {
                    let tableContent = `
                    <table class="table table-hover align-middle text-center" id="batch-table">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">Số lô</th>  
                                <th class="text-center">Tồn kho</th>
                                <th class="text-center">Hạn dùng</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                    `;
                    if (response.length > 0) {
                        response.forEach(inventory => {
                            const initialQuantity = inventory.current_quantity;
                            const batchNumber = inventory.batch_number; // Lấy batchNumber ở đây
                            const remainingQuantity = inventoryState[batchNumber] ?? initialQuantity;
                            const currentDate = new Date();
                            let displayExpiryDate = 'Không có';
                            let monthsDifference = null;
                            equipmentName = inventory.equipments.name;

                            if (inventory.expiry_date) {
                                const expiryDate = new Date(inventory.expiry_date);
                                monthsDifference = (expiryDate - currentDate) / (1000 * 60 * 60 * 24 * 30);
                                displayExpiryDate = monthsDifference > 5 ? formatDate(inventory.expiry_date) : 'Hết hạn';
                            }

                            // Tạo hàng mới trong bảng với tồn kho từ trạng thái đã lưu
                            tableContent += `
                            <tr class="batch-row ${monthsDifference !== null && monthsDifference <= 5 ? 'expired' : ''}" 
                                data-batch-number="${batchNumber}" 
                                data-initial-quantity="${initialQuantity}" 
                                data-current-quantity="${remainingQuantity}">
    
                                <td class="text-center">${batchNumber}</td>
                                <td class="text-center">${remainingQuantity}</td>
                                <td class="text-center">${displayExpiryDate}</td>
                                <td class="text-center d-flex justify-content-center">
                                    <input type="number" class="form-control form-control-sm border border-success rounded-pill quantity-input" 
                                        min="1" max="${remainingQuantity}" placeholder="Số lượng" style="text-align: left;">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-danger rounded-pill add-quantity" style="font-size: 11px;">Thêm</button>
                                </td>
                            </tr>
                            `;
                        });
                    } else {
                        tableContent += `
                        <tr id="noDataAlert">
                            <td colspan="5" class="text-center">
                                <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                                    role="alert"
                                    style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                    <div class="mb-3">
                                        <i class="fas fa-file-invoice" style="font-size: 36px; color: #6c757d;"></i>
                                    </div>
                                    <div class="text-center">
                                        <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Thông tin tồn kho trống</h5>
                                        <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                            Hiện tại chưa có vật tư nào được thêm vào. Vui lòng kiểm tra lại hoặc tạo mới vật tư để bắt đầu.
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        `;
                    }
                    tableContent += `</tbody></table>`;
                    batchInfoContainer.html(tableContent);

                    $('.add-quantity').on('click', function () {
                        const row = $(this).closest('tr');
                        const batchNumber = row.data('batch-number');
                        const currentQuantity = row.data('current-quantity');
                        const inputQuantity = parseInt(row.find('.quantity-input').val());

                        // Kiểm tra tính hợp lệ của số lượng nhập
                        if (!inputQuantity || isNaN(inputQuantity) || inputQuantity <= 0 || inputQuantity > currentQuantity) {
                            return; // Nếu số lượng không hợp lệ thì dừng lại
                        }

                        // Cập nhật số lượng tồn kho cho thiết bị
                        equipmentQuantities[batchNumber] = (equipmentQuantities[batchNumber] || 0) + inputQuantity;

                        // Cập nhật số lượng trong bảng
                        const existingRow = $('#material-list-body').find(`tr[data-batch-number="${batchNumber}"]`);
                        if (existingRow.length > 0) {
                            // Nếu dòng đã tồn tại, cập nhật số lượng
                            const existingInput = existingRow.find('.quantity-input-add');
                            const existingQuantity = parseInt(existingInput.val()) || 0;
                            const newQuantity = existingQuantity + inputQuantity;

                            // Cập nhật giá trị trong ô input
                            existingInput.val(newQuantity);

                            // Cập nhật lại số lượng tồn kho dựa trên số lượng ban đầu
                            const remainingQuantity = currentQuantity - inputQuantity; // Trừ số lượng nhập mới vào số lượng ban đầu
                            row.data('current-quantity', remainingQuantity); // Cập nhật dữ liệu mới
                            inventoryState[batchNumber] = remainingQuantity; // Cập nhật lại trạng thái tồn kho

                            // Cập nhật lại hiển thị trong bảng
                            row.find('td:nth-child(2)').text(remainingQuantity); // Cập nhật lại hiển thị số tồn kho
                        } else {
                            // Nếu dòng chưa tồn tại, thêm mới
                            const newRow = `
                            <tr data-batch-number="${batchNumber}" data-equipment-code="${equipmentCode}">
                                <td>${equipmentName}</td>
                                <td>${batchNumber}</td>
                                <td class="text-center d-flex justify-content-center"><input type="number" class="form-control form-control-sm border border-success rounded-pill quantity-input-add w-50" value="${inputQuantity}" placeholder="Số lượng" style="text-align: left;"></td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-material" style="font-size:10px"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>`;
                            $('#material-list-body').append(newRow);

                            // Cập nhật số lượng tồn kho
                            const remainingQuantity = currentQuantity - inputQuantity; // Trừ số lượng nhập vào số lượng ban đầu
                            row.find('td:nth-child(2)').text(remainingQuantity);
                            row.data('current-quantity', remainingQuantity); // Cập nhật dữ liệu mới
                            inventoryState[batchNumber] = remainingQuantity; // Cập nhật lại trạng thái tồn kho
                        }

                        // Reset ô nhập số lượng
                        row.find('.quantity-input').val('');
                    });


                    // Sự kiện thay đổi cho ô input số lượng
                    $(document).on('input', '.quantity-input', function () {
                        const row = $(this).closest('tr');
                        const batchNumber = row.data('batch-number');
                        const currentQuantity = row.data('current-quantity');
                        const inputQuantity = parseInt($(this).val());

                        // Kiểm tra tính hợp lệ của số lượng nhập
                        if (!inputQuantity || isNaN(inputQuantity) || inputQuantity <= 0 || inputQuantity > currentQuantity) {
                            $(this).addClass('is-invalid');
                            $(this).addClass('border-danger');
                        } else {
                            $(this).removeClass('is-invalid');
                            $(this).removeClass('border-danger');
                        }
                    });
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    batchInfoContainer.html('<div class="alert alert-danger text-center">Đã xảy ra lỗi khi lấy dữ liệu.</div>');
                }
            });
        } else {
            batchInfoContainer.html(`
                <table class="table table-hover table-striped align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Số lô</th>
                            <th class="text-center">Tồn kho</th>
                            <th class="text-center">Hạn dùng</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="noDataAlert">
                                <td colspan="12" class="text-center">
                                    <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                                        role="alert"
                                        style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                        <div class="mb-3">
                                            <i class="fas fa-file-invoice" style="font-size: 36px; color: #6c757d;"></i>
                                        </div>
                                        <div class="text-center">
                                            <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Thông tin phiếu
                                                xuất trống</h5>
                                            <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                Hiện tại chưa có phiếu xuất nào được thêm vào. Vui lòng kiểm tra lại hoặc
                                                tạo mới phiếu xuất để bắt đầu.
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                    </tbody>
                </table>
            `);
        }
    });
    $(document).on('input', '.quantity-input-add', function () {
        const row = $(this).closest('tr');
        const batchNumber = row.data('batch-number');
        const batchRow = $(`#batch-table tr[data-batch-number="${batchNumber}"]`);

        // Lấy giá trị tồn kho ban đầu
        const initialQuantity = parseInt(batchRow.data('initial-quantity')) || 0;
        const inputQuantity = parseInt($(this).val()) || 0;

        // Tính số lượng tồn kho hiện tại dựa trên tồn kho ban đầu và tổng số lượng đã nhập của lô đó
        const totalAddedQuantity = inputQuantity;
        const remainingQuantity = initialQuantity - totalAddedQuantity;

        // Cập nhật tồn kho trong bảng
        if (batchRow.length > 0) {
            batchRow.find('td:nth-child(2)').text(remainingQuantity);
            batchRow.data('current-quantity', remainingQuantity);
        }

        // Cập nhật tổng số lượng đã nhập cho lô đó
        equipmentQuantities[batchNumber] = totalAddedQuantity;
    });
    $(document).on('click', '.remove-equipment-btn', function () {
        $(this).closest('tr').remove();
    });

    $(document).on('click', '.remove-equipment-btn', function () {
        $(this).closest('tr').remove();
    });

    // Sự kiện xác nhận xóa vật tư trong danh sách
    // Sự kiện xác nhận xóa vật tư trong danh sách
    $(document).on('click', '.remove-material', function () {
        const rowToDelete = $(this).closest('tr');
        const batchNumber = rowToDelete.data('batch-number');
        const materialQuantity = parseInt(rowToDelete.find('.quantity-input-add').val()) || 0; // Lấy số lượng cần xóa

        // Hiển thị modal xác nhận xóa
        $('#confirmDelete').data('row-to-delete', rowToDelete).data('batch-number', batchNumber)
            .data('material-quantity', materialQuantity);
        $('#confirmDeleteModal').modal('show');
    });

    $('#confirmDelete').on('click', function () {
        const rowToDelete = $(this).data('row-to-delete');
        const batchNumber = $(this).data('batch-number');
        const materialQuantity = $(this).data('material-quantity');

        // Xóa dòng khỏi bảng vật tư
        rowToDelete.remove();

        // Cập nhật lại số lượng tồn kho bên trên
        const rowInBatchTable = $(`#batch-table tr[data-batch-number="${batchNumber}"]`);
        const currentBatchQuantityText = rowInBatchTable.find('td:nth-child(2)').text(); // Lấy giá trị text từ ô
        const currentBatchQuantity = parseInt(currentBatchQuantityText.trim(), 10); // Cắt khoảng trắng và chuyển đổi

        // Kiểm tra xem currentBatchQuantity có phải là NaN không

        // Cập nhật số lượng tồn kho
        const updatedBatchQuantity = currentBatchQuantity + materialQuantity;

        // Cập nhật giao diện và dữ liệu
        rowInBatchTable.find('td:nth-child(2)').text(updatedBatchQuantity); // Cập nhật lại hiển thị số tồn kho
        rowInBatchTable.data('current-quantity', updatedBatchQuantity); // Cập nhật lại data attribute
        inventoryState[batchNumber] = updatedBatchQuantity; // Cập nhật trạng thái tồn kho

        // Kiểm tra nếu không còn vật tư nào trong bảng
        // Đóng modal xác nhận xóa
        $('#confirmDeleteModal').modal('hide');
    });

    $('#inputQuantity').on('keypress', function (event) {
        if (event.which === 13) { // 13 là mã phím cho Enter
            event.preventDefault(); // Ngăn chặn hành vi mặc định
            $('#saveQuantity').click(); // Gọi sự kiện click của nút lưu
        }
    });

    // Sự kiện để kiểm tra input cho số lượng nhập
    $('#inputQuantity').on('input', function () {
        const inputQuantity = $(this).val();
        if (inputQuantity && !isNaN(inputQuantity) && parseInt(inputQuantity) > 0) {
            $('#inputQuantity').removeClass('is-invalid');
            $('#quantityError').text('');
        } else {
            $('#inputQuantity').addClass('is-invalid');
        }
    });
    // Format ngày theo dd/mm/yyyy
    function formatDate(dateString) {
        const date = new Date(dateString);
        const day = ('0' + date.getDate()).slice(-2); // Thêm số 0 nếu ngày nhỏ hơn 10
        const month = ('0' + (date.getMonth() + 1)).slice(-2); // Tháng bắt đầu từ 0, nên cần cộng 1
        const year = date.getFullYear();
        return `${day}/${month}/${year}`; // Trả về định dạng dd/mm/yyyy
    }

});
$(document).ready(function () {
    // Hàm để cập nhật dữ liệu từ bảng vào input ẩn
    function updateMaterialListInput() {
        const materialList = [];

        $('#material-list-body tr').each(function () {
            const batchNumber = $(this).data('batch-number'); // Lấy số lô từ thuộc tính data
            const equipmentCode = $(this).data('equipment-code'); // Lấy equipment_code từ thuộc tính data
            const quantity = $(this).find('.quantity-input-add').val(); // Sửa lại để lấy giá trị từ ô input

            if (batchNumber && quantity) { // Kiểm tra nếu có dữ liệu
                materialList.push({
                    equipment_code: equipmentCode, // Thêm equipment_code vào danh sách
                    batch_number: batchNumber,
                    quantity: quantity
                });
            }
        });

        // Lưu mảng dữ liệu vật tư dưới dạng JSON vào input ẩn
        $('#material_list_input').val(JSON.stringify(materialList));
    }



    // Khi form submit, gọi hàm để lưu dữ liệu vào input ẩn
    $('#warehouse-export-form').on('submit', function () {
        updateMaterialListInput();
    });
});

$(document).on('change', '#material_code', function () {
    const selectedOption = $(this).find(':selected');
    const totalInventory = parseInt(selectedOption.data('total-inventory')); // Lấy giá trị từ thuộc tính data

    // Kiểm tra tổng tồn và thêm class nếu bằng 0
    if (totalInventory === 0) {
        $(this).addClass('text-danger'); // Thêm lớp màu đỏ
    } else {
        $(this).removeClass('text-danger'); // Gỡ lớp màu đỏ nếu không bằng 0
    }
});


