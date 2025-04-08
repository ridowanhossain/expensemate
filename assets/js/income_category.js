$(document).ready(function () {
  const incomeCategoryTable = $("#incomeCategoryTable").DataTable({
    ajax: {
      url: "actions/income_category/fetch_income_categories.php",
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
      { data: "name" },
      { data: "comment" },
      { data: "action", orderable: false, searchable: false },
    ],
  });

  // Add Income Category
  $("#addIncomeCategoryForm").on("submit", function (e) {
    e.preventDefault();
    const formData = $(this).serialize();
    $.post(
      "actions/income_category/add_income_category.php",
      formData,
      function (response) {
        if (response.success) {
          $("#addIncomeCategoryModal").modal("hide");
          $("#addIncomeCategoryForm")[0].reset();
          incomeCategoryTable.ajax.reload();
          showToast("Success", response.message, "success");
        } else {
          showToast("Error", response.message, "danger");
        }
      },
      "json"
    );
  });

  // Edit Income Category
  $("#incomeCategoryTable").on("click", ".edit-btn", function () {
    const id = $(this).data("id");
    $.post(
      "actions/income_category/get_income_category.php",
      { id },
      function (response) {
        if (response.success) {
          $("#editIncomeCategoryId").val(response.data.id);
          $("#editIncomeCategoryName").val(response.data.name);
          $("#editIncomeCategoryComment").val(response.data.comment);
          $("#editIncomeCategoryModal").modal("show");
        } else {
          showToast(
            "Error",
            "Failed to fetch Income Category details.",
            "danger"
          );
        }
      },
      "json"
    );
  });

  $("#editIncomeCategoryForm").on("submit", function (e) {
    e.preventDefault();
    const formData = $(this).serialize();
    $.post(
      "actions/income_category/update_income_category.php",
      formData,
      function (response) {
        if (response.success) {
          $("#editIncomeCategoryModal").modal("hide");
          $("#editIncomeCategoryForm")[0].reset();
          incomeCategoryTable.ajax.reload();
          showToast(
            "Success",
            response.message || "Updated successfully!",
            "success"
          );
        } else {
          showToast(
            "Error",
            response.message || "No changes were made.",
            "warning"
          );
        }
      },
      "json"
    );
  });

  // Delete Income Category
  $("#incomeCategoryTable").on("click", ".delete-btn", function () {
    const id = $(this).data("id");
    showConfirmationToast(
      "Confirmation",
      "Are you sure you want to delete this Income Category?",
      function () {
        $.post(
          "actions/income_category/delete_income_category.php",
          { id },
          function (response) {
            if (response.success) {
              incomeCategoryTable.ajax.reload();
              showToast(
                "Success",
                "Income Category deleted successfully!",
                "success"
              );
            } else {
              showToast("Error", "Failed to delete Income Category.", "danger");
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

  // General Toast Function
  function showToast(title, message, type) {
    const toastHtml = `
            <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong>${title}</strong>: ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>`;
    $("#toastContainer").append(toastHtml);
    const toastElement = $(".toast:last-child")[0];
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
    $(toastElement).on("hidden.bs.toast", function () {
      $(this).remove();
    });
  }

  // Confirmation Toast Function
  function showConfirmationToast(title, message, onConfirm) {
    const toastHtml = `
            <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong>${title}</strong>: ${message}
                        <div class="mt-2 d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-sm btn-success confirm-btn">Confirm</button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="toast">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>`;
    $("#toastContainer").append(toastHtml);
    const toastElement = $(".toast:last-child")[0];
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
    $(toastElement)
      .find(".confirm-btn")
      .on("click", function () {
        onConfirm();
        toast.hide();
      });
    $(toastElement).on("hidden.bs.toast", function () {
      $(this).remove();
    });
  }
});
