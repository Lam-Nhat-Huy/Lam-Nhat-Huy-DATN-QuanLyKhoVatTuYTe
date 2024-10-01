let materialData = [];
let totalCount = 0;
let matchedCount = 0;
let mismatchedCount = 0;
let uncheckedCount = 0;

// Filter products based on user input
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

// Select product from dropdown
function selectProduct(element, name, equipment_code, current_quantity, batch_number) {
    addProductToTable(name, equipment_code, current_quantity, batch_number);
    document.getElementById('productDropdown').style.display = 'none';
    document.getElementById('searchProductInput').value = '';
}

// Add product to table and initialize counts
function addProductToTable(name, equipment_code, current_quantity, batch_number) {
    totalCount++;
    uncheckedCount++;

    var tableBody = document.getElementById('materialList');
    var rowCount = materialData.length;

    var row = `
        <tr data-index="${rowCount}">
            <td>
                <a href="#" class="text-dark" onclick="removeProduct(${rowCount})">
                    <i class="fa fa-trash"></i>
                </a>
            </td>
            <td>${rowCount + 1}</td>
            <td>${equipment_code}</td>
            <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${name}</td>
            <td>${current_quantity}</td>
            <td>
                <input type="number" style="width: 70px; height: 40px; border-radius: 8px;" oninput="updateProduct(${rowCount}, this.value)">
            </td>
            <td class="unequal-count" id="unequal-count-${rowCount}">0</td>
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

    updateCounts(); // Update counts display

    if (tableBody.rows.length > 0) {
        document.getElementById('noDataAlert').style.display = 'none';
    }
}

// Remove product from table and update counts
function removeProduct(index) {
    var tableBody = document.getElementById('materialList');
    var row = tableBody.querySelector(`tr[data-index="${index}"]`);
    if (row) {
        tableBody.removeChild(row);
        materialData.splice(index, 1);
        totalCount--;
        uncheckedCount--;
        updateRowIndices();
        updateCounts(); // Update counts display
        if (tableBody.rows.length === 0) {
            document.getElementById('noDataAlert').style.display = 'table-row';
        }
    }
}

// Update row indices after removal
function updateRowIndices() {
    var tableBody = document.getElementById('materialList');
    Array.from(tableBody.rows).forEach((row, index) => {
        row.setAttribute('data-index', index);
        row.cells[1].textContent = index + 1; // Update STT column
    });
}

// Update product quantity and calculate differences
function updateProduct(index, value) {
    if (materialData[index]) {
        materialData[index].actual_quantity = value;

        // Calculate the unequal count
        const current_quantity = materialData[index].current_quantity;
        const unequal = value - current_quantity;
        materialData[index].unequal = unequal;

        // Update the UI to show the unequal count
        const unequalCountCell = document.getElementById(`unequal-count-${index}`);
        unequalCountCell.textContent = unequal; // Display the unequal quantity

        // Update matched and mismatched counts
        if (value > 0) {
            if (unequal === 0) {
                matchedCount++;
                mismatchedCount = Math.max(0, mismatchedCount - 1);
            } else {
                mismatchedCount++;
                matchedCount = Math.max(0, matchedCount - 1);
            }
        }

        updateCounts(); // Update counts display
    }
}

// Update displayed counts
function updateCounts() {
    document.getElementById('totalCount').textContent = totalCount;
    document.getElementById('matchedCount').textContent = matchedCount;
    document.getElementById('mismatchedCount').textContent = mismatchedCount;
    document.getElementById('uncheckedCount').textContent = uncheckedCount;

    // Show or hide noDataAlert based on the number of products
    const noDataAlert = document.getElementById('noDataAlert');
    noDataAlert.style.display = materialData.length === 0 ? 'table-row' : 'none';
}

// Add all products to the table
function addAllProducts() {
    var tableBody = document.getElementById('materialList');

    products.forEach(product => {
        product.inventories.forEach(inventory => {
            if (!materialData.some(item => item.equipment_code === inventory.equipment_code)) {
                addProductToTable(product.name, inventory.equipment_code, inventory.current_quantity, inventory.batch_number);
            }
        });
    });
}

// Submit materials data
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
