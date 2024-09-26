let materialData = [];

function filterProducts() {
    var input = document.getElementById('searchProductInput');
    var filter = input.value.toUpperCase();
    var dropdown = document.getElementById('productDropdown');

    // Hiển thị dropdown khi nhập liệu
    dropdown.style.display = filter ? 'block' : 'none';
    dropdown.innerHTML = '';

    var filteredProducts = products.filter(function(product) {
        return product.name.toUpperCase().indexOf(filter) > -1;
    });

    filteredProducts.forEach(function(product) {
        product.inventories.forEach(function(inventory) {
            var item = `
                <a class="dropdown-item d-flex align-items-center" href="#" onclick="selectProduct(this, '${product.name}', '${inventory.equipment_code}', ${inventory.current_quantity}, '${inventory.batch_number}')">
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

// Hàm thêm vật tư khi search
function selectProduct(element, name, equipment_code, current_quantity, batch_number) {
    addProductToTable(name, equipment_code, current_quantity, batch_number);
    document.getElementById('productDropdown').style.display = 'none';
    document.getElementById('searchProductInput').value = '';
}


function addProductToTable(name, equipment_code, current_quantity, batch_number) {
    var tableBody = document.getElementById('materialList');
    var rowCount = tableBody.rows.length + 1;

    var row = `
        <tr>
            <td>
                <a href="#" class="text-dark" onclick="removeProduct(${rowCount - 1})">
                    <i class="fa fa-trash"></i>
                </a>
            </td>
            <td>${rowCount}</td>
            <td>${equipment_code}</td>
            <td>${name}</td>
            <td>${current_quantity}</td>
            <td>
                <input type="number" min="0"
                       onchange="updateProduct(${rowCount - 1}, this.value)">
            </td>
            <td>0</td>
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
}


function updateProduct(index, actualQuantity) {
    actualQuantity = parseInt(actualQuantity);

    var current_quantity = materialData[index].current_quantity;
    var unequal = actualQuantity - current_quantity;

    materialData[index].actual_quantity = actualQuantity;
    materialData[index].unequal = unequal;

    document.querySelectorAll('#materialList tr')[index].querySelector('td:nth-child(7)').innerText = unequal;
}

function submitMaterials() {
    var checkDate = document.getElementById('check_date').value;
    var note = document.getElementById('note').value;
    var created_by = document.getElementById('created_by').value;
    var status = document.querySelector('button[name="status"]:focus').value

    materialData = materialData.map(function(material) {
        return {
            ...material,
            check_date: checkDate,
            note: note,
            status: status,
            created_by: created_by
        };
    });

    // Update the hidden input with the JSON stringified materialData
    document.getElementById('materialData').value = JSON.stringify(materialData);
}

