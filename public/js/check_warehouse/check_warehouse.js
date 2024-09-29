let materialData = [];

function filterProducts() {
    var input = document.getElementById('searchProductInput');
    var filter = input.value.toUpperCase();
    var dropdown = document.getElementById('productDropdown');

    // Hiển thị dropdown khi nhập liệu
    dropdown.style.display = filter ? 'block' : 'none';
    dropdown.innerHTML = ''; // Reset lại nội dung dropdown

    var filteredProducts = products.filter(function(product) {
        return product.name.toUpperCase().indexOf(filter) > -1;
    });

    if (filteredProducts.length === 0) {
        // Nếu không có kết quả, hiển thị thông báo
        var noResultItem = `
            <div class="dropdown-item text-center">
                Không tìm thấy kết quả
            </div>
        `;
        dropdown.insertAdjacentHTML('beforeend', noResultItem);
    } else {
        filteredProducts.forEach(function(product) {
            product.inventories.forEach(function(inventory) {
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

// Hàm thêm vật tư khi search
function selectProduct(element, name, equipment_code, current_quantity, batch_number) {
    addProductToTable(name, equipment_code, current_quantity, batch_number);
    document.getElementById('productDropdown').style.display = 'none';
    document.getElementById('searchProductInput').value = '';
}


function addProductToTable(name, equipment_code, current_quantity, batch_number) {
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

    if (tableBody.rows.length > 0) {
        var noDataAlert = document.getElementById('noDataAlert');
        if (noDataAlert) {
            noDataAlert.style.display = 'none';
        }
    }
}


function updateProduct(index, actualQuantity) {
    actualQuantity = parseInt(actualQuantity);

    if (materialData[index]) {
        var current_quantity = materialData[index].current_quantity;
        var unequal = actualQuantity - current_quantity;

        materialData[index].actual_quantity = actualQuantity;
        materialData[index].unequal = unequal;

        document.querySelector(`#materialList tr[data-index="${index}"] td:nth-child(7)`).innerText = unequal;
    } else {
        console.error('Invalid index:', index);
    }
}


function removeProduct(index) {
    // Xóa dòng trong bảng
    var row = document.querySelector(`#materialList tr[data-index="${index}"]`);
    if (row) {
        row.remove();
    }

    // Xóa sản phẩm khỏi mảng materialData
    materialData.splice(index, 1);

    // Cập nhật lại chỉ số trong bảng sau khi xóa
    var rows = document.querySelectorAll('#materialList tr');
    rows.forEach((row, i) => {
        row.setAttribute('data-index', i);
        row.querySelector('td:nth-child(2)').innerText = i + 1; // Cập nhật lại số thứ tự
        row.querySelector('a').setAttribute('onclick', `removeProduct(${i})`); // Cập nhật lại sự kiện onclick
        row.querySelector('input').setAttribute('onchange', `updateProduct(${i}, this.value)`); // Cập nhật lại sự kiện onchange
    });

    // Kiểm tra nếu không còn dữ liệu để hiển thị thông báo "Không có dữ liệu"
    if (materialData.length === 0) {
        var noDataAlert = document.getElementById('noDataAlert');
        if (noDataAlert) {
            noDataAlert.style.display = 'block'; // Hiển thị lại alert nếu danh sách trống
        }
    }
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

