$(document).ready(function () {
  // Function to initialize Datepicker
  function initializeDatepicker(selector) {
    $(selector).datepicker({
      dateFormat: "dd/mm/yy", // Display format
      changeMonth: true,
      changeYear: true,
      yearRange: "1900:2100",
    });
  }

  // Function to set today's date in DD/MM/YYYY format
  function setTodayDate(selector) {
    const today = new Date();
    const formattedToday = `${String(today.getDate()).padStart(
      2,
      "0"
    )}/${String(today.getMonth() + 1).padStart(2, "0")}/${today.getFullYear()}`;
    $(selector).val(formattedToday);
  }

  // Initialize Datepickers for Income and Expense
  initializeDatepicker("#incomeDate");
  initializeDatepicker("#expenseDate");
  initializeDatepicker("#editDate");

  // Set today's date for Income and Expense
  setTodayDate("#incomeDate");
  setTodayDate("#expenseDate");

  // Function to convert date to YYYY-MM-DD format
  function convertDateToISO(date) {
    const parts = date.split("/"); // Split the date string by "/"
    return `${parts[2]}-${parts[1]}-${parts[0]}`; // Rearrange as YYYY-MM-DD
  }

  // Function to convert YYYY-MM-DD to DD/MM/YYYY
  function formatToDDMMYYYY(date) {
    const [year, month, day] = date.split("-");
    return `${day}/${month}/${year}`;
  }

  // Function to convert DD/MM/YYYY to YYYY-MM-DD
  function formatToYYYYMMDD(date) {
    const [day, month, year] = date.split("/");
    return `${year}-${month}-${day}`;
  }

  // Function to add Categories into the Add Income Modal
  $("#addIncomeModal").on("show.bs.modal", function () {
    $.ajax({
      url: "actions/fetch_add_income_category.php", // Ensure the correct path
      method: "GET",
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          const categorySelect = $("#incomeCategory");
          categorySelect.empty(); // Clear any existing options
          categorySelect.append(
            '<option value="" disabled selected>Select a category</option>'
          );

          // Populate the select dropdown with categories
          response.categories.forEach(function (category) {
            categorySelect.append(
              `<option value="${category.id}">${category.name}</option>`
            );
          });
        } else {
          showToast("Error", response.message, "danger");
        }
      },
      error: function () {
        showToast(
          "Error",
          "Failed to fetch categories. Please try again.",
          "danger"
        );
      },
    });
  });

  // Function to Add Income
  $("#incomeForm").on("submit", function (e) {
    e.preventDefault();

    // Convert date to ISO format (YYYY-MM-DD)
    const incomeDate = $("#incomeDate").val();
    const formattedDate = convertDateToISO(incomeDate);
    $("#incomeDate").val(formattedDate); // Update the date value in the form

    $.ajax({
      url: "actions/save_income.php", // Your endpoint for saving income
      type: "POST",
      data: $(this).serialize(), // Include all form data (amount, category_id, comment, date)
      success: function (response) {
        const result = JSON.parse(response);
        if (result.status === "success") {
          showToast("Success", result.message, "success"); // Show success toast
          $("#addIncomeModal").modal("hide");
          fetchStatistics();
          table.ajax.reload(); // Reload the DataTable
          $("#incomeForm")[0].reset(); // Reset the form after saving
          setTodayDate("#incomeDate"); // Reset the date to today's date
        } else {
          showToast("Error", result.message, "danger"); // Show error toast
        }
      },
      error: function () {
        showToast(
          "Error",
          "Failed to save income. Please try again.",
          "danger"
        );
      },
    });
  });


  // Function to add Categories into the Add Expense Modal
  $("#addExpenseModal").on("show.bs.modal", function () {
    $.ajax({
      url: "actions/fetch_add_expense_category.php", // Ensure the correct path
      method: "GET",
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          const categorySelect = $("#expenseCategory");
          categorySelect.empty(); // Clear any existing options
          categorySelect.append(
            '<option value="" disabled selected>Select a category</option>'
          );

          // Populate the select dropdown with categories
          response.categories.forEach(function (category) {
            categorySelect.append(
              `<option value="${category.id}">${category.name}</option>`
            );
          });
        } else {
          showToast("Error", response.message, "danger");
        }
      },
      error: function () {
        showToast(
          "Error",
          "Failed to fetch categories. Please try again.",
          "danger"
        );
      },
    });
  });

  // Function to Add expense
  $("#expenseForm").on("submit", function (e) {
    e.preventDefault();

    // Convert date to ISO format (YYYY-MM-DD)
    const expenseDate = $("#expenseDate").val();
    const formattedDate = convertDateToISO(expenseDate);
    $("#expenseDate").val(formattedDate); // Update the date value in the form

    $.ajax({
      url: "actions/save_expense.php", // Your endpoint for saving expense
      type: "POST",
      data: $(this).serialize(), // Include all form data (amount, category_id, comment, date)
      success: function (response) {
        const result = JSON.parse(response);
        if (result.status === "success") {
          showToast("Success", result.message, "success"); // Show success toast
          $("#addExpenseModal").modal("hide");
          fetchStatistics();
          table.ajax.reload(); // Reload the DataTable
          $("#expenseForm")[0].reset(); // Reset the form after saving
          setTodayDate("#expenseDate"); // Reset the date to today's date
        } else {
          showToast("Error", result.message, "danger"); // Show error toast
        }
      },
      error: function () {
        showToast(
          "Error",
          "Failed to save expense. Please try again.",
          "danger"
        );
      },
    });
  });

  // Open Edit Modal
  $("#datatablesSimple").on("click", ".edit-btn", function () {
    const data = $(this).data();
    $("#editId").val(data.id);
    $("#editType").val(data.type);
    $("#editComment").val(data.comment);
    $("#editDate").val(data.date);
    $("#editAmount").val(data.amount);
    $("#editModal").modal("show");
  });

  // Populate the Edit Modal with data
  $(document).on("click", ".edit-btn", function () {
    const id = $(this).data("id");
    const type = $(this).data("type");
    const category_id = $(this).data("category-id");
    const comment = $(this).data("comment");
    const date = $(this).data("date");
    const amount = $(this).data("amount");

    $("#editId").val(id);
    $("#editType").val(type);
    $("#editComment").val(comment);
    $("#editDate").val(formatToDDMMYYYY(date));
    $("#editAmount").val(amount);

    const fetchCategoryUrl =
      type === "income"
        ? "actions/fetch_add_income_category.php"
        : "actions/fetch_add_expense_category.php";

    $.ajax({
      url: fetchCategoryUrl,
      type: "GET",
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          const categories = response.categories;
          const categorySelect = $("#editCategory");
          categorySelect.empty();
          categorySelect.append(
            '<option value="" disabled>Select a category</option>'
          );
          categories.forEach((category) => {
            const selected = category.id == category_id ? "selected" : "";
            categorySelect.append(
              `<option value="${category.id}" ${selected}>${category.name}</option>`
            );
          });
        } else {
          showToast(
            "Error",
            "Failed to fetch categories. Please try again.",
            "danger"
          );
        }
      },
      error: function () {
        showToast("Error", "Error loading categories.", "danger");
      },
    });

    $("#editModal").modal("show");
  });

  // Save Changes (for editing)
  $("#editForm").on("submit", function (e) {
    e.preventDefault();

    const id = $("#editId").val();
    const type = $("#editType").val();
    const category_id = $("#editCategory").val();
    const comment = $("#editComment").val();
    const date = formatToYYYYMMDD($("#editDate").val());
    const amount = $("#editAmount").val();

    if (!category_id) {
      showToast("Warning", "Please select a category.", "warning");
      return;
    }

    $.post(
      "actions/update_entry.php",
      {
        id: id,
        type: type,
        category_id: category_id,
        comment: comment,
        date: date,
        amount: amount,
      },
      function (response) {
        if (response.status === "success") {
          $("#editModal").modal("hide");
          showToast("Success", response.message, "success");
          fetchStatistics();
          table.ajax.reload();
        } else {
          showToast("Error", response.message, "danger");
        }
      },
      "json"
    ).fail(function () {
      showToast(
        "Error",
        "An error occurred while saving the changes.",
        "danger"
      );
    });
  });

  // Delete Entry
  $("#datatablesSimple").on("click", ".delete-btn", function () {
    const id = $(this).data("id");
    const type = $(this).data("type");

    showConfirmationToast(
      "Delete Entry",
      "Are you sure you want to delete this entry?",
      function () {
        $.post(
          "actions/delete_entry.php",
          { id: id, type: type },
          function (response) {
            if (response.status === "success") {
              showToast("Success", response.message, "success");
              table.ajax.reload(); // Reload table
              fetchStatistics(); // Update statistics
            } else {
              showToast("Error", "Error: " + response.message, "danger");
            }
          },
          "json"
        ).fail(function () {
          showToast(
            "Error",
            "Failed to delete the entry. Please try again.",
            "danger"
          );
        });
      }
    );
  });


  // Function to fetch and update statistics
  function fetchStatistics() {
    $.ajax({
      url: "actions/fetch_statistics.php",
      type: "GET",
      dataType: "json",
      success: function (response) {
        if (response) {
          $("#current_month_income").text(response.month_income);
          $("#current_month_expense").text(response.month_expense);
          $("#current_month_balance").text(response.month_balance);
          $("#previous_month_balance").text(response.prev_balance);
          $("#total_income").text(response.total_income);
          $("#total_expense").text(response.total_expense);
          $("#total_balance").text(response.total_balance);
          $("#last_month_income").text(response.last_month_income);
          $("#last_month_expense").text(response.last_month_expense);
        }
      },
      error: function (xhr, status, error) {
        console.error("Failed to fetch statistics:", error);
      },
    });
  }

  // Call fetchStatistics on page load
  fetchStatistics();

  // DataTable Initialization
  const table = $("#datatablesSimple").DataTable({
    ajax: {
      url: "actions/fetch_ledger.php",
      type: "POST",
      data: { action: "fetch_ledger" },
      dataSrc: "data",
    },
    columns: [
      { data: null, render: (data, type, row, meta) => meta.row + 1 },
      { data: "category" },
      { data: "comment" },
      { data: "type" },
      {
        data: "date",
        render: function (data, type, row) {
          if (type === "display" || type === "filter") {
            return moment(data).format("DD/MM/YYYY");
          }
          return data; // Return original format for other types (e.g., sorting)
        },
      },
      { data: "time" },
      { data: "amount" },
      { data: "action", orderable: false, searchable: false },
    ],
    paging: true,
    searching: true,
    responsive: true,
    lengthMenu: [
      [15, 25, 50, 100, -1],
      [15, 25, 50, 100, "All"],
    ],
    dom:
      '<"row mb-3"<"col-sm-12"B>>' +
      '<"row mb-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
      '<"row"<"col-sm-12"tr>>' +
      '<"row"<"d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-3"i><"d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-3"p>>',
    buttons: [
      {
        extend: "copy",
        text: "Copy",
        title: "Ledger Data",
        exportOptions: {
          columns: ":not(:last-child)",
          modifier: {
            search: "applied",
            order: "applied",
            page: "all",
          },
        },
      },
      {
        extend: "pdf",
        text: "PDF",
        title: "Ledger Data",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, -1], // Include relevant columns and exclude the Action column
          modifier: {
            search: "applied",
            order: "applied",
            page: "all",
          },
        },
        customize: function (doc) {
          doc.styles.tableHeader.fontSize = 12; // Header font size
          doc.defaultStyle.fontSize = 10; // Body font size

          // Modify headers to include Income Amount, Expense Amount, and Balance columns
          doc.content[1].table.body[0] = [
            { text: "No", bold: true },
            { text: "Category", bold: true },
            { text: "Comment", bold: true },
            { text: "Date", bold: true },
            { text: "Time", bold: true },
            { text: "Income Amount", bold: true },
            { text: "Expense Amount", bold: true },
          ];

          // Clear existing rows and populate with modified data
          const tableBody = doc.content[1].table.body;
          tableBody.splice(1); // Remove all rows except the header

          const tableData = table.rows({ search: "applied" }).data();

          let totalIncome = 0;
          let totalExpense = 0;

          tableData.each((row, index) => {
            const incomeAmount =
              row.type === "Income"
                ? parseFloat(row.amount.replace(/,/g, "") || 0)
                : 0;
            const expenseAmount =
              row.type === "Expense"
                ? parseFloat(row.amount.replace(/,/g, "") || 0)
                : 0;

            totalIncome += incomeAmount;
            totalExpense += expenseAmount;

            tableBody.push([
              (index + 1).toString(), // Row number
              row.category || "", // Category
              row.comment || "", // Comment
              row.date || "", // Date
              row.time || "", // Time
              incomeAmount ? incomeAmount.toLocaleString() : "", // Income Amount
              expenseAmount ? expenseAmount.toLocaleString() : "", // Expense Amount
            ]);
          });

          // Calculate Balance
          const balance = totalIncome - totalExpense;

          // Add totals and balance row
          tableBody.push([
            { text: "Total", colSpan: 5, alignment: "right", bold: true },
            {},
            {},
            {},
            {},
            {
              text: totalIncome.toLocaleString(undefined, {
                minimumFractionDigits: 2,
              }),
              bold: true,
            },
            {
              text: totalExpense.toLocaleString(undefined, {
                minimumFractionDigits: 2,
              }),
              bold: true,
            },
          ]);

          // Add balance row
          tableBody.push([
            { text: "Balance", colSpan: 6, alignment: "right", bold: true },
            {},
            {},
            {},
            {},
            {}, // Placeholder cells for correct alignment
            {
              text: balance.toLocaleString(undefined, {
                minimumFractionDigits: 2,
              }),
              bold: true,
            },
          ]);

          // Adjust column widths
          doc.content[1].table.widths = [
            "5%",
            "15%",
            "25%",
            "10%",
            "10%",
            "15%",
            "15%",
          ];
        },
      },
      {
        extend: "print",
        text: "Print",
        title: "Ledger Data",
        customize: function (win) {
          const tableBody = $(win.document.body).find("table tbody");
          let totalIncome = 0;
          let totalExpense = 0;

          const tableData = table.rows({ search: "applied" }).data();
          for (let i = 0; i < tableData.length; i++) {
            const amount = parseFloat(
              (tableData[i].amount || "0").replace(/,/g, "")
            );
            if (tableData[i].type === "Income") {
              totalIncome += amount;
            } else if (tableData[i].type === "Expense") {
              totalExpense += amount;
            }
          }

          const formattedIncome =
            totalIncome % 1 === 0
              ? totalIncome.toLocaleString()
              : totalIncome.toLocaleString(undefined, {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
                });

          const formattedExpense =
            totalExpense % 1 === 0
              ? totalExpense.toLocaleString()
              : totalExpense.toLocaleString(undefined, {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
                });

          // Calculate Balance
          const balance = totalIncome - totalExpense;
          const formattedBalance =
            balance % 1 === 0
              ? balance.toLocaleString()
              : balance.toLocaleString(undefined, {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
                });

          tableBody.append(`
                        <tr>
                            <td colspan="6" style="text-align:right; font-weight:bold;">Total Income:</td>
                            <td style="font-weight:bold;">${formattedIncome}</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-align:right; font-weight:bold;">Total Expense:</td>
                            <td style="font-weight:bold;">${formattedExpense}</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-align:right; font-weight:bold;">Balance:</td>
                            <td style="font-weight:bold;">${formattedBalance}</td>
                        </tr>
                    `);

          $(win.document.body).find("tfoot").remove();
          $(win.document.body).find("table").addClass("print-table");
        },
        exportOptions: {
          columns: ":not(:last-child)", // Exclude the Action column
          modifier: {
            search: "applied",
            order: "applied",
            page: "all", // Include all rows
          },
          stripHtml: false,
        },
      },
      {
        extend: "excel",
        text: "Excel",
        title: "Ledger Data",
        exportOptions: {
          columns: ":not(:last-child)", // Exclude the Action column
          modifier: {
            search: "applied",
            order: "applied",
            page: "all", // Include all rows
          },
        },
        customize: function (xlsx) {
          const sheet = xlsx.xl.worksheets["sheet1.xml"];
          const rows = $("row", sheet);

          rows.last().remove();
          // Initialize totals
          let totalIncome = 0;
          let totalExpense = 0;

          // Traverse through data to calculate income and expense totals
          const tableData = table.rows({ search: "applied" }).data();
          for (let i = 0; i < tableData.length; i++) {
            const amount = parseFloat(
              (tableData[i].amount || "0").replace(/,/g, "")
            );
            if (tableData[i].type === "Income") {
              totalIncome += amount;
            } else if (tableData[i].type === "Expense") {
              totalExpense += amount;
            }
          }

          // Format totals
          const formattedIncome = totalIncome.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
          });

          const formattedExpense = totalExpense.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
          });

          // Calculate balance
          const balance = totalIncome - totalExpense;
          const formattedBalance = balance.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
          });

          // Add Total Row
          const incomeRow = `
                        <row>
                            <c t="inlineStr"><is><t></t></is></c>
                            <c t="inlineStr"><is><t></t></is></c>
                            <c t="inlineStr"><is><t></t></is></c>
                            <c t="inlineStr"><is><t></t></is></c>
                            <c t="inlineStr"><is><t></t></is></c>
                            <c t="inlineStr" s="42"><is><t>Income:</t></is></c>
                            <c t="inlineStr" s="42"><is><t>${formattedIncome}</t></is></c>
                        </row>
                    `;

          // Add Total Row
          const expenseRow = `
                        <row>
                            <c t="inlineStr"><is><t></t></is></c>
                            <c t="inlineStr"><is><t></t></is></c>
                            <c t="inlineStr"><is><t></t></is></c>
                            <c t="inlineStr"><is><t></t></is></c>
                            <c t="inlineStr"><is><t></t></is></c>
                            <c t="inlineStr" s="42"><is><t>Expense:</t></is></c>
                            <c t="inlineStr" s="42"><is><t>${formattedExpense}</t></is></c>
                        </row>
                    `;

          const balanceRow = `
                        <row>
                            <c t="inlineStr"><is><t></t></is></c>
                            <c t="inlineStr"><is><t></t></is></c>
                            <c t="inlineStr"><is><t></t></is></c>
                            <c t="inlineStr"><is><t></t></is></c>
                            <c t="inlineStr"><is><t></t></is></c>
                            <c t="inlineStr" s="42"><is><t>Balance:</t></is></c>
                            <c t="inlineStr" s="42"><is><t>${formattedBalance}</t></is></c>
                        </row>
                    `;

          const dataRows = $("row", sheet);
          dataRows.last().after(balanceRow);
          dataRows.last().after(expenseRow);
          dataRows.last().after(incomeRow);
        },
      },
      {
        extend: "colvis",
        text: "Column Visibility",
        columns: ":not(:last-child)",
      },
    ],
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
