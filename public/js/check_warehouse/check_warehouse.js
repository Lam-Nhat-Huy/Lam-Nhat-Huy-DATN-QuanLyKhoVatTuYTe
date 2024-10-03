let materialData = [];
let totalCount = 0;
let matchedCount = 0;
let mismatchedCount = 0;
let uncheckedCount = 0;

function filterProducts() {
    var input = document.getElementById('searchProductInput');
    var filter = input.value.toUpperCase();
    var dropdown = document.getElementById('productDropdown');

    dropdown.style.display = filter ? 'block' : 'none';
    dropdown.innerHTML = '';

    var filteredProducts = products.filter(function (product) {
        return product.name.toUpperCase().indexOf(filter) > -1;
    });

    if (filteredProducts.length === 0) {
        var noResultItem = `
            <div class="dropdown-item text-center">
                Không tìm thấy kết quả
            </div>
        `;
        dropdown.insertAdjacentHTML('beforeend', noResultItem);
    } else {
        filteredProducts.forEach(function (product) {
            product.inventories.forEach(function (inventory) {
                var item = `
                    <a class="dropdown-item d-flex align-items-center" href="#"
                        onclick="selectProduct(this, '${product.name}', '${inventory.equipment_code}', ${inventory.current_quantity}, '${inventory.batch_number}')">
                        <img src="https://png.pngtree.com/template/20190316/ourlarge/pngtree-medical-health-logo-image_79595.jpg" alt="Product Image" class="me-2" style="width: 40px; height: 40px;">
                        <div>
                            <div class="fw-bold">${product.name}</div>
                            <small>${inventory.equipment_code} - Tồn kho: ${inventory.current_quantity} - Lô: ${inventory.batch_number}</small>
                        </div>
                    </a>
                `;
                dropdown.insertAdjacentHTML('beforeend', item);
            });
        });
    }
}

function selectProduct(element, name, equipment_code, current_quantity, batch_number) {
    addProductToTable(name, equipment_code, current_quantity, batch_number);
    document.getElementById('productDropdown').style.display = 'none';
    document.getElementById('searchProductInput').value = '';
}

function addProductToTable(name, equipment_code, current_quantity, batch_number) {
    var existingMaterial = materialData.find(material => material.equipment_code === equipment_code && material.batch_number === batch_number);

    if (existingMaterial) {
        document.getElementById('importantNotificationContent').innerHTML = `Thiết bị <strong>${name}</strong> với mã <strong>${equipment_code}</strong> và lô <strong>${batch_number}</strong> đã tồn tại.`;
        $('#importantNotificationModal').modal('show');
        return;
    }

    totalCount++;
    uncheckedCount++;

    var tableBody = document.getElementById('materialList');
    var rowCount = materialData.length;

    var row = `
        <tr data-index="${rowCount}">
            <td>${rowCount + 1}</td>    
            <td>${equipment_code}</td>
            <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${name}</td>
            <td>${batch_number}</td>
            <td>${current_quantity}</td>
            <td>
                <input type="number" style="width: 70px; height: 40px; border-radius: 8px;" oninput="updateProduct(${rowCount}, this.value)">
            </td>
            <td class="unequal-count" id="unequal-count-${rowCount}">0</td>
            <td>
                <button class="btn btn-primary" type="button" onclick="autoFillQuantity(${rowCount}, ${current_quantity})">
                    <i class="fa fa-random"></i>
                </button>

                <a href="#" class="text-dark" onclick="removeProduct(${rowCount})">
                    <i class="fa fa-trash"></i>
                </a>
            </td>
        </tr>
    `;

    tableBody.insertAdjacentHTML('beforeend', row);

    materialData.push({
        equipment_code: equipment_code,
        current_quantity: current_quantity,
        actual_quantity: null,
        unequal: 0,
        batch_number: batch_number
    });

    updateCounts();

    if (tableBody.rows.length > 0) {
        document.getElementById('noDataAlert').style.display = 'none';
    }
}


function removeProduct(index) {
    var tableBody = document.getElementById('materialList');
    var row = tableBody.querySelector(`tr[data-index="${index}"]`);
    if (row) {
        tableBody.removeChild(row);
        materialData.splice(index, 1);
        totalCount--;
        uncheckedCount--;
        updateRowIndices();
        updateCounts();
        if (tableBody.rows.length === 0) {
            document.getElementById('noDataAlert').style.display = 'table-row';
        }
    }
}

function updateRowIndices() {
    var tableBody = document.getElementById('materialList');
    Array.from(tableBody.rows).forEach((row, index) => {
        row.setAttribute('data-index', index);
        row.cells[1].textContent = index + 1;
    });
}

function updateProduct(index, value) {
    if (materialData[index]) {
        materialData[index].actual_quantity = value;

        const current_quantity = materialData[index].current_quantity;
        const unequal = value - current_quantity;
        materialData[index].unequal = unequal;

        const unequalCountCell = document.getElementById(`unequal-count-${index}`);
        unequalCountCell.textContent = unequal;
        if (value > 0) {
            if (unequal === 0) {
                matchedCount++;
                mismatchedCount = Math.max(0, mismatchedCount - 1);
            } else {
                mismatchedCount++;
                matchedCount = Math.max(0, matchedCount - 1);
            }
        }

        updateCounts();
    }
}

function updateCounts() {
    document.getElementById('totalCount').textContent = totalCount;
    document.getElementById('matchedCount').textContent = matchedCount;
    document.getElementById('mismatchedCount').textContent = mismatchedCount;
    document.getElementById('uncheckedCount').textContent = uncheckedCount;

    const noDataAlert = document.getElementById('noDataAlert');
    noDataAlert.style.display = materialData.length === 0 ? 'table-row' : 'none';
}

function addAllProducts() {
    var tableBody = document.getElementById('materialList');

    products.forEach(product => {
        product.inventories.forEach(inventory => {
            // Bỏ điều kiện kiểm tra trùng lặp, để luôn thêm tất cả sản phẩm và lô hàng
            addProductToTable(product.name, inventory.equipment_code, inventory.current_quantity, inventory.batch_number);
        });
    });
}


function submitMaterials() {
    var checkDate = document.getElementById('check_date').value;
    var note = document.getElementById('note').value;
    var created_by = document.getElementById('created_by').value;
    var status = document.querySelector('button[name="status"]:focus').value;

    materialData = materialData.map(function (material) {
        return {
            ...material,
            check_date: checkDate,
            note: note,
            status: status,
            created_by: created_by
        };
    });

    document.getElementById('materialData').value = JSON.stringify(materialData);
}


function autoFillQuantity(index, current_quantity) {
    var inputField = document.querySelector(`tr[data-index="${index}"] input[type="number"]`);
    inputField.value = current_quantity;
    updateProduct(index, current_quantity);
}

function autoFillAllQuantities() {
    materialData.forEach((material, index) => {
        var current_quantity = material.current_quantity;

        var inputField = document.querySelector(`tr[data-index="${index}"] input[type="number"]`);

        if (inputField) {
            inputField.value = current_quantity;

            updateProduct(index, current_quantity);
        }
    });
}
