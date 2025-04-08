$(document).ready(function () {
  // Show Income Modal with Today's Date
  $("#income-button").click(function () {
    var today = new Date().toISOString().split("T")[0];
    $("#income-date").val(today); // Set today's date in income date field
    $("#incomeModal").modal("show");
  });

  // Show Expense Modal with Today's Date
  $("#expense-button").click(function () {
    var today = new Date().toISOString().split("T")[0];
    $("#expense-date").val(today); // Set today's date in expense date field
    $("#expenseModal").modal("show");
  });

  // Save Income Data and Reset Form
  $("#save-income").click(function () {
    $.post("save_income.php", $("#income-form").serialize(), function () {
      $("#incomeModal").modal("hide");
      $("#income-form")[0].reset(); // Reset the form after saving
      updateStatistics(); // Update statistics
      loadLedger(); // Reload ledger
    });
  });

  // Save Expense Data and Reset Form
  $("#save-expense").click(function () {
    $.post("save_expense.php", $("#expense-form").serialize(), function () {
      $("#expenseModal").modal("hide");
      $("#expense-form")[0].reset(); // Reset the form after saving
      updateStatistics(); // Update statistics
      loadLedger(); // Reload ledger
    });
  });

  const table = $('#datatablesSimple').DataTable({
    ajax: {
        url: '', // This same PHP file for AJAX request
        type: 'POST',
        data: {
            action: 'fetch_ledger'
        },
        dataSrc: 'data'
    },
    columns: [{
            data: 'comment'
        },
        {
            data: 'date'
        },
        {
            data: 'amount'
        },
        {
            data: 'type'
        },
        {
            data: 'action',
            orderable: false,
            searchable: false
        }
    ],
    paging: true,
    searching: true,
    order: [
        [1, 'desc']
    ],
    responsive: true
});

  // Update Statistics (Left Panel)
  function updateStatistics() {
    $.get(
      "fetch_statistics.php",
      function (data) {
        $("#month-income").text("$" + (data.month_income || "0.00"));
        $("#month-expense").text("$" + (data.month_expense || "0.00"));
        $("#month-balance").text("$" + (data.month_balance || "0.00"));
        $("#prev-balance").text("$" + (data.prev_balance || "0.00"));
        $("#total-balance").text("$" + (data.total_balance || "0.00"));
      },
      "json"
    );
  }

  // Edit Income/Expense: Open Edit Modal with Pre-filled Data
  $(document).on("click", ".edit-btn", function () {
    $("#edit-id").val($(this).data("id"));
    $("#edit-type").val($(this).data("type"));
    $("#edit-comment").val($(this).data("comment"));
    $("#edit-date").val($(this).data("date"));
    $("#edit-amount").val($(this).data("amount"));
    $("#editModal").modal("show");
  });

  // Handle delete button click
  $(document).on("click", ".delete-btn", function () {
    const entryId = $(this).data("id");
    const entryType = $(this).data("type");

    // Show confirmation dialog
    if (
      confirm(
        "Are you sure you want to delete this entry? This action cannot be undone."
      )
    ) {
      // If user confirms, send AJAX request to delete the entry
      $.ajax({
        url: "delete_entry.php",
        method: "POST",
        data: { id: entryId, type: entryType },
        success: function (response) {
          if (response === "success") {
            alert("Entry deleted successfully.");
            loadLedger(); // Reload the ledger after deletion
            updateStatistics(); // Update statistics
          } else {
            alert("Failed to delete the entry. Please try again.");
          }
        },
        error: function () {
          alert("An error occurred while deleting the entry.");
        },
      });
    }
  });

  // Save Edited Data with AJAX and Reload Ledger and Statistics
  $("#saveChanges").click(function () {
    $.ajax({
      url: "update_entry.php",
      method: "POST",
      data: $("#editForm").serialize(),
      success: function (response) {
        if (response === "success") {
          $("#editModal").modal("hide"); // Close the modal
          loadLedger(); // Reload ledger to reflect changes
          updateStatistics(); // Update statistics
        } else {
          alert("An error occurred while updating the entry.");
        }
      },
    });
  });

  // Initialize Date Range Picker for Ledger Filtering
  $("#date-range").daterangepicker({
    opens: "left",
    autoUpdateInput: false,
    locale: {
      format: "YYYY-MM-DD",
    },
  });

  // Set Date Range Picker Value and Trigger Filter on Apply
  $("#date-range").on("apply.daterangepicker", function (ev, picker) {
    var startDate = picker.startDate.format("YYYY-MM-DD");
    var endDate = picker.endDate.format("YYYY-MM-DD");
    $("#date-range").val(startDate + " - " + endDate); // Display selected range
    updateFilteredLedger(startDate, endDate); // Trigger ledger filter
  });

  // Manually Trigger Ledger Filter with Date Range
  $("#filter-ledger").click(function () {
    const dateRange = $("#date-range").val();
    if (!dateRange) {
      alert("Please select a date range.");
      return;
    }

    var [startDate, endDate] = dateRange.split(" - ");
    updateFilteredLedger(startDate, endDate); // Call filter function
  });

  // Function to Update Filtered Ledger by Date Range
  function updateFilteredLedger(startDate, endDate) {
    $.ajax({
      url: "fetch_filtered_ledger.php",
      method: "POST",
      data: { start_date: startDate, end_date: endDate },
      success: function (response) {
        $("#filtered-ledger-body").html(response); // Show filtered ledger data
      },
      error: function () {
        alert("Error fetching filtered ledger data.");
      },
    });
  }














  


  // Initial Load of Statistics and Ledger
  updateStatistics();
  loadLedger();
});







