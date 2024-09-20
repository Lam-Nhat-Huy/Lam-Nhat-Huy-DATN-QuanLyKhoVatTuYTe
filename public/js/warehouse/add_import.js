let materialData = [];

function addMaterial() {
    const supplier_code = document.getElementById('supplier_code').value;
    const note = document.getElementById('note').value;
    const equipment_code = document.getElementById('equipment_code').value;
    const receipt_date = document.getElementById('receipt_date').value;
    const created_by = document.getElementById('created_by').value;
    const receipt_no = document.getElementById('receipt_no').value;
    const batch_number = document.getElementById('batch_number').value;
    const product_date = document.getElementById('product_date').value;
    const expiry_date = document.getElementById('expiry_date').value;
    const price = parseFloat(document.getElementById('price').value);
    const quantity = parseInt(document.getElementById('quantity').value);
    const discount = parseFloat(document.getElementById('discount_rate').value);
    const VAT = parseFloat(document.getElementById('VAT').value);

    // Validation
    let errors = [];
    const today = new Date();
    const receiptDate = new Date(receipt_date);
    const productDate = new Date(product_date);
    const expiryDate = new Date(expiry_date);

    if (!supplier_code) errors.push('Vui lòng chọn nhà cung cấp.');
    if (!receipt_no) errors.push('Vui lòng nhập số hóa đơn.');
    if (!equipment_code) errors.push('Vui lòng chọn tên vật tư.');
    if (!batch_number) errors.push('Vui lòng nhập số lô.');
    if (!receipt_date || receiptDate > today) errors.push('Ngày nhập phải nhỏ hơn hoặc bằng ngày hôm nay.');
    if (!product_date || productDate > receiptDate) errors.push('Ngày sản xuất phải nhỏ hơn hoặc bằng ngày nhập.');
    if (!expiry_date || expiryDate <= productDate) errors.push('Hạn sử dụng phải lớn hơn ngày sản xuất.');
    if (!price || price <= 0) errors.push('Vui lòng nhập giá nhập hợp lệ.');
    if (!quantity || quantity <= 0) errors.push('Vui lòng nhập số lượng hợp lệ.');
    if (!discount || discount < 0 || discount > 100) errors.push('Vui lòng nhập chiết khấu hợp lệ (0-100%).');
    if (!VAT || VAT < 0 || VAT > 100) errors.push('Vui lòng nhập VAT hợp lệ (0-100%).');

    if (errors.length > 0) {
        const errorMessages = document.getElementById('errorMessages');
        const errorList = document.getElementById('errorList');

        errorList.innerHTML = '';
        errors.forEach(error => {
            const li = document.createElement('li');
            li.textContent = error;
            errorList.appendChild(li);
        });

        errorMessages.style.display = 'block';
        return;
    }

    document.getElementById('errorMessages').style.display = 'none';

    // Continue adding material if no errors
    const total_price = price * quantity * (1 - discount / 100) * (1 + VAT / 100);
    const material = {
        supplier_code,
        note,
        receipt_no,
        receipt_date,
        created_by,
        batch_number,
        expiry_date,
        quantity,
        VAT,
        discount,
        equipment_code,
        price,
        total_price: total_price.toFixed(2)
    };
    materialData.push(material);

    updateMaterialTable();
    calculateTotals();
}

function updateMaterialTable() {
    const tableBody = document.getElementById('materialList');
    const noMaterialAlert = document.getElementById('noMaterialAlert');

    // Clear existing rows
    tableBody.innerHTML = '';

    if (materialData.length === 0) {
        // Show alert if no material added
        noMaterialAlert.style.display = 'table-row';
    } else {
        // Hide the no-material alert
        noMaterialAlert.style.display = 'none';

        // Add material rows
        materialData.forEach((material, index) => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td style="font-size: 11px;" class="text-center">${material.equipment_code}</td>
                <td style="font-size: 11px;" class="text-center">${material.supplier_code}</td>
                <td style="font-size: 11px;" class="text-center">${material.quantity}</td>
                <td style="font-size: 11px;" class="text-center">${material.price}</td>
                <td style="font-size: 11px;" class="text-center">${material.batch_number}</td>
                <td style="font-size: 11px;" class="text-center">${material.expiry_date}</td>
                <td style="font-size: 11px;" class="text-center">${material.discount}</td>
                <td style="font-size: 11px;" class="text-center">${material.VAT}</td>
                <td style="font-size: 11px;" class="text-center">${material.total_price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }).replace(',00', '')}</td>
                <td class="text-center">
                    <button onclick="removeMaterial(${index}, this)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }
}

function removeMaterial(index, element) {
    materialData.splice(index, 1);
    updateMaterialTable();
    calculateTotals();
}

function calculateTotals() {
    let totalDiscount = 0;
    let totalVAT = 0;
    let totalAmount = 0;

    materialData.forEach(material => {
        const itemDiscount = material.price * material.quantity * material.discount / 100;
        const itemVAT = (material.price * material.quantity - itemDiscount) * material.VAT / 100;
        const itemTotal = material.total_price;

        totalDiscount += itemDiscount;
        totalVAT += itemVAT;
        totalAmount += parseFloat(itemTotal);
    });

    document.getElementById('totalDiscount').textContent = totalDiscount.toLocaleString('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).replace(',00', '');
    document.getElementById('totalVAT').textContent = totalVAT.toLocaleString('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).replace(',00', '');
    document.getElementById('totalAmount').textContent = totalAmount.toLocaleString('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).replace(',00', '');
}

function submitMaterials() {
    document.getElementById('materialData').value = JSON.stringify(materialData);
}
