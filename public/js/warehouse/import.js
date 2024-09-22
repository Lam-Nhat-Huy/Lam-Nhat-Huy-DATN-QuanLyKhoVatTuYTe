document.getElementById('selectAll').addEventListener('change', function() {
    var isChecked = this.checked;
    var checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = isChecked;
        var row = checkbox.closest('tr');
        if (isChecked) {
            row.classList.add('selected-row');
        } else {
            row.classList.remove('selected-row');
        }
    });
});

document.querySelectorAll('.row-checkbox').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        var row = this.closest('tr');
        if (this.checked) {
            row.classList.add('selected-row');
        } else {
            row.classList.remove('selected-row');
        }

        var allChecked = true;
        document.querySelectorAll('.row-checkbox').forEach(function(cb) {
            if (!cb.checked) {
                allChecked = false;
            }
        });
        document.getElementById('selectAll').checked = allChecked;
    });
});

document.querySelectorAll('tbody tr').forEach(function(row) {
    row.addEventListener('click', function() {
        var checkbox = this.querySelector('.row-checkbox');
        if (checkbox) {
            checkbox.checked = !checkbox.checked;
            if (checkbox.checked) {
                this.classList.add('selected-row');
            } else {
                this.classList.remove('selected-row');
            }

            var allChecked = true;
            document.querySelectorAll('.row-checkbox').forEach(function(cb) {
                if (!cb.checked) {
                    allChecked = false;
                }
            });
            document.getElementById('selectAll').checked = allChecked;
        }
    });
});

document.getElementById('printPdfBtn').addEventListener('click', function() {
    var printContents = document.getElementById('printArea').innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
});
