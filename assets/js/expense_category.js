$(document).ready(function () {
  const expenseCategoryTable = $("#expenseCategoryTable").DataTable({
    ajax: {
      url: "actions/expense_category/fetch_expense_categories.php",
      type: "POST",
      dataSrc: "data",
    },
    columns: [
      {
        data: null,
        orderable: false,
        searchable: false,
        render: (data, type, row, meta) => meta.row + 1,
      },
      { data: "id" },
      { data: "name" },
      { data: "comment" },
      { data: "action", orderable: false, searchable: false },
    ],
  });

  $("#addExpenseCategoryForm").on("submit", function (e) {
    e.preventDefault();
    const formData = $(this).serialize();

    $.post(
      "actions/expense_category/add_expense_category.php",
      formData,
      function (response) {
        if (response.success) {
          $("#addExpenseCategoryModal").modal("hide");
          $("#addExpenseCategoryForm")[0].reset();
          expenseCategoryTable.ajax.reload();
          showToast(
            "Success",
            "Expense Category added successfully!",
            "success"
          );
        } else {
          showToast("Error", "Failed to add Expense Category.", "danger");
        }
      },
      "json"
    );
  });

  $("#expenseCategoryTable").on("click", ".edit-btn", function () {
    const id = $(this).data("id");

    $.post(
      "actions/expense_category/get_expense_category.php",
      { id },
      function (response) {
        if (response.success) {
          $("#editExpenseCategoryId").val(response.data.id);
          $("#editExpenseCategoryName").val(response.data.name);
          $("#editExpenseCategoryComment").val(response.data.comment);
          $("#editExpenseCategoryModal").modal("show");
        } else {
          showToast(
            "Error",
            "Failed to fetch Expense Category details.",
            "danger"
          );
        }
      },
      "json"
    );
  });

  $("#editExpenseCategoryForm").on("submit", function (e) {
    e.preventDefault();
    const formData = $(this).serialize();

    $.post(
      "actions/expense_category/update_expense_category.php",
      formData,
      function (response) {
        if (response.success) {
          $("#editExpenseCategoryModal").modal("hide");
          expenseCategoryTable.ajax.reload();
          showToast(
            "Success",
            "Expense Category updated successfully!",
            "success"
          );
        } else {
          showToast("Error", "Failed to update Expense Category.", "danger");
        }
      },
      "json"
    );
  });

  $("#expenseCategoryTable").on("click", ".delete-btn", function () {
    const id = $(this).data("id");

    showConfirmationToast(
      "Confirmation",
      "Are you sure you want to delete this Expense Category?",
      function () {
        $.post(
          "actions/expense_category/delete_expense_category.php",
          { id },
          function (response) {
            if (response.success) {
              expenseCategoryTable.ajax.reload();
              showToast(
                "Success",
                "Expense Category deleted successfully!",
                "success"
              );
            } else {
              showToast(
                "Error",
                "Failed to delete Expense Category.",
                "danger"
              );
            }
          },
          "json"
        ).fail(function () {
          showToast(
            "Error",
            "Failed to process the request. Please try again.",
            "danger"
          );
        });
      }
    );
  });

  function showToast(title, message, type) {
    const toast = `
            <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong>${title}:</strong> ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>`;
    $("#toastContainer").append(toast);
    const toastElement = $(".toast:last")[0];
    const bsToast = new bootstrap.Toast(toastElement);
    bsToast.show();
    $(toastElement).on("hidden.bs.toast", function () {
      $(this).remove();
    });
  }

  function showConfirmationToast(title, message, onConfirm) {
    const toast = `
            <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong>${title}:</strong> ${message}
                        <div class="d-flex justify-content-end gap-2 mt-2">
                            <button id="confirmBtn" type="button" class="btn btn-warning btn-sm">Confirm</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>`;
    $("#toastContainer").append(toast);
    const toastElement = $(".toast:last")[0];
    const bsToast = new bootstrap.Toast(toastElement);
    bsToast.show();
    $("#confirmBtn").on("click", function () {
      onConfirm();
      bsToast.hide();
    });
    $(toastElement).on("hidden.bs.toast", function () {
      $(this).remove();
    });
  }
});
