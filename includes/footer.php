    </main>
    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Ridowan Hossain <?php echo date("Y"); ?></div>
                <div>
                    <a href="https://service.techogram.com">Techogram</a>
                </div>
            </div>
        </div>
    </footer>
    </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/r-3.0.3/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <!-- Date Range Picker JS -->
    <script src="https://cdn.jsdelivr.net/npm/moment/moment.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.js"></script>
    <script src="assets/js/scripts.js"></script>
        <?php
            $currentPage = basename($_SERVER['PHP_SELF']);
            if ($currentPage === 'index.php') {
                echo '<script src="assets/js/index.js"></script>';
            };
            if ($currentPage === 'income.php') {
                echo '<script src="assets/js/income.js"></script>';
            };
            if ($currentPage === 'expense.php') {
                echo '<script src="assets/js/expense.js"></script>';
            };
            if ($currentPage === 'income_statement.php') {
                echo '<script src="assets/js/income_statement.js"></script>';
            };
            if ($currentPage === 'this_month_statement.php') {
                echo '<script src="assets/js/this_month_statement.js"></script>';
            };
            if ($currentPage === 'last_month_statement.php') {
                echo '<script src="assets/js/last_month_statement.js"></script>';
            };
            if ($currentPage === 'income_category.php') {
                echo '<script src="assets/js/income_category.js"></script>';
            };
            if ($currentPage === 'expense_category.php') {
                echo '<script src="assets/js/expense_category.js"></script>';
            };
            if ($currentPage === 'user.php') {
                echo '<script src="assets/js/user.js"></script>';
            };
        ?>
    <script>
        






















    






        
    </script>
    </body>

    </html>