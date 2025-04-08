$(document).ready(function () {
  // Fetch user information on page load
  $.get(
    "actions/get_user.php",
    function (data) {
      if (data.success) {
        $("#fullname").val(data.user.fullname);
        $("#username").val(data.user.username);
      } else {
        alert("Failed to fetch user data.");
      }
    },
    "json"
  );

  // Handle form submission with AJAX
  $("#userEditForm").on("submit", function (e) {
    e.preventDefault();

    $.post(
      "actions/update_user.php",
      $(this).serialize(),
      function (response) {
        const toastEl = $("#updateToast");
        const toastMessage = $("#toastMessage");

        if (response.success) {
          toastEl.removeClass("bg-danger").addClass("bg-primary");
          toastMessage.text(response.message);
        } else {
          toastEl.removeClass("bg-primary").addClass("bg-danger");
          toastMessage.text(response.message);
        }

        // Show the toast
        const toast = new bootstrap.Toast(toastEl[0]);
        toast.show();
      },
      "json"
    );
  });
});
