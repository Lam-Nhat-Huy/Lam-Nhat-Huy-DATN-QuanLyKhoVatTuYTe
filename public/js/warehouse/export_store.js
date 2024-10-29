$(document).ready(function () {
    let equipmentName;
    let equipmentQuantities = {};
    let inventoryState = {};

    $("#material_code").on("change", function () {
        const equipmentCode = $(this).val();
        const batchInfoContainer = $("#batch_info");
        batchInfoContainer.html("");

        if (equipmentCode) {
            $.ajax({
                url: postExportUrl,
                method: "POST",
                data: {
                    _token: csrfToken,
                    equipment_code: equipmentCode,
                },
                success: function (response) {
                    let tableContent = `
                    <table class="table table-hover align-middle text-center" id="batch-table">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">Mã thiết bị</th>  
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
                        response.forEach((inventory) => {
                            const initialQuantity = inventory.current_quantity;
                            const batchNumber = inventory.batch_number;
                            const equipment_code = inventory.equipment_code;
                            const remainingQuantity =
                                inventoryState[
                                    `${batchNumber}-${equipmentCode}`
                                ] ?? initialQuantity;
                            const currentDate = new Date();
                            let displayExpiryDate = "Không có";
                            let monthsDifference = null;

                            equipmentName = inventory.equipments.name;

                            if (inventory.expiry_date) {
                                const expiryDate = new Date(
                                    inventory.expiry_date
                                );
                                monthsDifference =
                                    (expiryDate - currentDate) /
                                    (1000 * 60 * 60 * 24 * 30);
                                displayExpiryDate =
                                    monthsDifference > 5
                                        ? formatDate(inventory.expiry_date)
                                        : "Hết hạn";
                            }

                            tableContent += `
                            <tr class="batch-row ${
                                monthsDifference !== null &&
                                monthsDifference <= 5
                                    ? "expired"
                                    : ""
                            }" 
                                data-batch-number="${batchNumber}" 
                                data-initial-quantity="${initialQuantity}" 
                                data-current-quantity="${remainingQuantity}"    
                                data-equipment-name="${equipmentName}"> 
                                <td class="text-center">${equipment_code}</td>
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

                    // Hàm thêm thiết bị
                    $(".add-quantity").on("click", function () {
                        const row = $(this).closest("tr");
                        const batchNumber = row.data("batch-number");
                        const equipmentCode = $("#material_code").val();
                        const equipmentName = row.data("equipment-name");
                        const currentQuantity = row.data("current-quantity");
                        const inputQuantity = parseInt(
                            row.find(".quantity-input").val()
                        );
                        const quantityInputField = row.find(".quantity-input");

                        // Kiểm tra nếu số lượng nhập vào không hợp lệ hoặc vượt quá tồn kho hiện tại
                        if (
                            !inputQuantity ||
                            isNaN(inputQuantity) ||
                            inputQuantity <= 0 ||
                            inputQuantity > currentQuantity
                        ) {
                            quantityInputField.addClass("is-invalid");
                            return;
                        } else {
                            quantityInputField.removeClass("is-invalid");
                        }

                        const uniqueKey = `${batchNumber}-${equipmentCode}`;
                        let existingRow = $(
                            `#material-list-body tr[data-key="${uniqueKey}"]`
                        );

                        if (existingRow.length > 0) {
                            let existingInput = existingRow.find(
                                ".quantity-input-add"
                            );
                            let previousQuantity =
                                parseInt(existingInput.val()) || 0;

                            if (
                                previousQuantity + inputQuantity >
                                currentQuantity
                            ) {
                                alert("Số lượng vượt quá tồn kho!");
                                return;
                            }

                            existingInput.val(previousQuantity + inputQuantity);
                        } else {
                            const newRow = `
                                <tr data-key="${uniqueKey}" data-batch-number="${batchNumber}" data-equipment-code="${equipmentCode}">
                                    <td>${equipmentCode}</td>
                                    <td class="text-start">${equipmentName}</td>
                                    <td>${batchNumber}</td>
                                    <td class="text-center d-flex justify-content-center">
                                        <input type="number" class="form-control form-control-sm border border-success rounded-pill quantity-input-add w-50" 
                                            value="${inputQuantity}" max="${currentQuantity}" placeholder="Số lượng" style="text-align: left;">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-material" style="font-size:10px">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>`;
                            $("#material-list-body").append(newRow);
                        }

                        // Cập nhật tồn kho sau khi thêm số lượng
                        const remainingQuantity =
                            currentQuantity - inputQuantity;
                        row.find("td:nth-child(3)").text(remainingQuantity);
                        row.data("current-quantity", remainingQuantity);
                        inventoryState[uniqueKey] = remainingQuantity;

                        row.find(".quantity-input").val("");
                    });
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    batchInfoContainer.html(
                        '<div class="alert alert-danger text-center">Đã xảy ra lỗi khi lấy dữ liệu.</div>'
                    );
                },
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
                            <td colspan="5" class="text-center">
                                <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                                    role="alert"
                                    style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                    <div class="mb-3">
                                        <i class="fas fa-file-invoice" style="font-size: 36px; color: #6c757d;"></i>
                                    </div>
                                    <div class="text-center">
                                        <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Thông tin phiếu xuất trống</h5>
                                        <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                            Hiện tại chưa có phiếu xuất nào được thêm vào. Vui lòng kiểm tra lại hoặc tạo mới phiếu xuất để bắt đầu.
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

    $(document).on("input", ".quantity-input-add", function () {
        const row = $(this).closest("tr");
        const batchNumber = row.data("batch-number");
        const batchRow = $(
            `#batch-table tr[data-batch-number="${batchNumber}"]`
        );

        const initialQuantity =
            parseInt(batchRow.data("initial-quantity")) || 0;
        const inputQuantity = parseInt($(this).val()) || 0;

        const totalAddedQuantity = inputQuantity;
        const remainingQuantity = initialQuantity - totalAddedQuantity;

        if (batchRow.length > 0) {
            batchRow.find("td:nth-child(3)").text(remainingQuantity);
            batchRow.data("current-quantity", remainingQuantity);
        }

        equipmentQuantities[batchNumber] = totalAddedQuantity;
    });

    $(document).on("click", ".remove-equipment-btn", function () {
        $(this).closest("tr").remove();
    });

    $(document).on("click", ".remove-equipment-btn", function () {
        $(this).closest("tr").remove();
    });

    $(document).on("click", ".remove-material", function () {
        const rowToDelete = $(this).closest("tr");
        const batchNumber = rowToDelete.data("batch-number");
        const materialQuantity =
            parseInt(rowToDelete.find(".quantity-input-add").val()) || 0;

        $("#confirmDelete")
            .data("row-to-delete", rowToDelete)
            .data("batch-number", batchNumber)
            .data("material-quantity", materialQuantity);
        $("#confirmDeleteModal").modal("show");
    });

    $("#confirmDelete").on("click", function () {
        const rowToDelete = $(this).data("row-to-delete");
        const batchNumber = $(this).data("batch-number");
        const materialQuantity = $(this).data("material-quantity");

        rowToDelete.remove();

        const rowInBatchTable = $(
            `#batch-table tr[data-batch-number="${batchNumber}"]`
        );
        const currentBatchQuantityText = rowInBatchTable
            .find("td:nth-child(3)")
            .text();
        const currentBatchQuantity = parseInt(
            currentBatchQuantityText.trim(),
            10
        );

        const updatedBatchQuantity = currentBatchQuantity + materialQuantity;

        rowInBatchTable.find("td:nth-child(3)").text(updatedBatchQuantity);
        rowInBatchTable.data("current-quantity", updatedBatchQuantity);
        inventoryState[batchNumber] = updatedBatchQuantity;

        $("#confirmDeleteModal").modal("hide");
    });

    $("#inputQuantity").on("keypress", function (event) {
        if (event.which === 13) {
            event.preventDefault();
            $("#saveQuantity").click();
        }
    });

    $("#inputQuantity").on("input", function () {
        const inputQuantity = $(this).val();
        if (
            inputQuantity &&
            !isNaN(inputQuantity) &&
            parseInt(inputQuantity) > 0
        ) {
            $("#inputQuantity").removeClass("is-invalid");
            $("#quantityError").text("");
        } else {
            $("#inputQuantity").addClass("is-invalid");
        }
    });

    function formatDate(dateString) {
        const date = new Date(dateString);
        const day = ("0" + date.getDate()).slice(-2);
        const month = ("0" + (date.getMonth() + 1)).slice(-2);
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    }
});

$(document).ready(function () {
    function updateMaterialListInput() {
        const materialList = [];

        $("#material-list-body tr").each(function () {
            const batchNumber = $(this).data("batch-number");
            const equipmentCode = $(this).data("equipment-code");
            const quantity = $(this).find(".quantity-input-add").val();

            if (batchNumber && quantity) {
                materialList.push({
                    equipment_code: equipmentCode,
                    batch_number: batchNumber,
                    quantity: quantity,
                });
            }
        });

        $("#material_list_input").val(JSON.stringify(materialList));
    }

    $("#warehouse-export-form").on("submit", function () {
        updateMaterialListInput();
    });
});

$(document).on("change", "#material_code", function () {
    const selectedOption = $(this).find(":selected");
    const totalInventory = parseInt(selectedOption.data("total-inventory"));

    if (totalInventory === 0) {
        $(this).addClass("text-danger");
    } else {
        $(this).removeClass("text-danger");
    }
});
