document.getElementById('selectAll').addEventListener('change', function () {
    var isChecked = this.checked;
    var checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(function (checkbox) {
        checkbox.checked = isChecked;
        var row = checkbox.closest('tr');
        if (isChecked) {
            row.classList.add('selected-row');
        } else {
            row.classList.remove('selected-row');
        }
    });
});
document.querySelectorAll('.row-checkbox').forEach(function (checkbox) {
    checkbox.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    checkbox.addEventListener('change', function () {
        var row = this.closest('tr');
        if (this.checked) {
            row.classList.add('selected-row');
        } else {
            row.classList.remove('selected-row');
        }
        var allChecked = true;
        document.querySelectorAll('.row-checkbox').forEach(function (cb) {
            if (!cb.checked) {
                allChecked = false;
            }
        });
        document.getElementById('selectAll').checked = allChecked;
    });
});
document.querySelectorAll('tbody tr').forEach(function (row) {
    row.addEventListener('click', function (e) {
        if (!e.target.classList.contains('row-checkbox')) {
            var checkbox = this.querySelector('.row-checkbox');
            if (checkbox) {
                checkbox.checked = !checkbox.checked;
                if (checkbox.checked) {
                    this.classList.add('selected-row');
                } else {
                    this.classList.remove('selected-row');
                }
                var allChecked = true;
                document.querySelectorAll('.row-checkbox').forEach(function (cb) {
                    if (!cb.checked) {
                        allChecked = false;
                    }
                });
                document.getElementById('selectAll').checked = allChecked;
            }
        }
    });
});
function printInvoice(code) {
    const printContents = document.getElementById(`printArea_${code}`).innerHTML;
    const originalContents = document.body.innerHTML;

    // Thay đổi nội dung trang thành nội dung cần in
    document.body.innerHTML = printContents;

    // Gọi lệnh in của trình duyệt
    window.print();

    // Khôi phục lại trạng thái của trang
    window.location.reload();
}

