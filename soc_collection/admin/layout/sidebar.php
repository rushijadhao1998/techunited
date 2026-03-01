<div class="sidebar">

    <!-- Sidebar Header -->
    <div class="d-flex align-items-center justify-content-between px-3 mt-3">
        <h5 class="mb-0">Society Admin</h5>

        <button class="btn btn-sm btn-outline-light" id="menu-toggle">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <style>
        .menu-group {
            cursor: pointer;
            font-weight: 600;
        }

        .submenu {
            display: none;
            padding-left: 20px;
        }

        .submenu a {
            font-size: 14px;
            padding: 8px 20px;
            display: block;
        }

        .rotate {
            transform: rotate(90deg);
            transition: 0.2s;
        }
    </style>

    <hr>

    <a href="dashboard.php">
        <i class="bi bi-speedometer2 me-2"></i><span>Dashboard</span>
    </a>

    <a href="create-branch.php">
        <i class="bi bi-building me-2"></i><span>Create Branch</span>
    </a>

    <a href="branch-list.php">
        <i class="bi bi-list-ul me-2"></i><span>Branch List</span>
    </a>

    <a href="create-gl.php">
        <i class="bi bi-journal-plus me-2"></i><span>Create Ledger</span>
    </a>

    <a href="gl-list.php">
        <i class="bi bi-journal-text me-2"></i><span>Ledger List</span>
    </a>



    <a href="add-agent.php">
        <i class="bi bi-person-plus me-2"></i><span>Add Agent</span>
    </a>

    <a href="agent-list.php">
        <i class="bi bi-people me-2"></i><span>Agent List</span>
    </a>



    <a href="customer-list.php">
        <i class="bi bi-person-lines-fill me-2"></i><span>Customers</span>
    </a>

    <a href="agent-statement.php">
        <i class="bi bi-file-earmark-text me-2"></i><span>Agent Statement</span>
    </a>

    <a href="transaction-entry.php">
        <i class="bi bi-cash-coin me-2"></i><span>Transaction Entry</span>
    </a>

    <!-- <a href="open-account.php">
        <i class="bi bi-folder-plus me-2"></i><span>Open Account</span>
    </a>

    <a href="daily-report.php">
        <i class="bi bi-calendar-day me-2"></i><span>Daily Report</span>
    </a>

    <a href="monthly-report.php">
        <i class="bi bi-calendar-month me-2"></i><span>Monthly Report</span>
    </a> -->

    <!-- IMPORT & EXPORT -->
    <a class="menu-group" onclick="toggleMenu('importMenu',this)">
        <i class="bi bi-upload me-2"></i><span>Import & Export</span>
        <i class="bi bi-chevron-right float-end"></i>
    </a>

    <div id="importMenu" class="submenu">
        <a href="import-customers.php"><i class="bi bi-people me-2"></i><span>Import Customers</span></a>
        <a href="export-transactions.php"><i class="bi bi-file-earmark-excel me-2"></i><span>Export Transactions</span></a>
    </div>



    <!-- UTILITY -->
    <a class="menu-group" onclick="toggleMenu('utilityMenu',this)">
        <i class="bi bi-gear me-2"></i><span>Utility</span>
        <i class="bi bi-chevron-right float-end"></i>
    </a>

    <div id="utilityMenu" class="submenu">
        <a href="backup.php"><i class="bi bi-database me-2"></i><span>Backup</span></a>
        <a href="inactive-branches.php"><i class="bi bi-house-dash me-2"></i><span>Inactive Branches</span></a>
        <a href="inactive-gl.php"><i class="bi bi-journal-x me-2"></i><span>Inactive Ledgers</span></a>
        <a href="inactive-agents.php"><i class="bi bi-person-dash me-2"></i><span>Inactive Agents</span></a>
    </div>


    <a href="logout.php" class="text-danger">
        <i class="bi bi-box-arrow-right me-2"></i><span>Logout</span>
    </a>

</div>

<div class="content">

    <script>
        function toggleMenu(id, el) {
            let menu = document.getElementById(id);
            let icon = el.querySelector('.bi-chevron-right');

            if (menu.style.display === "block") {
                menu.style.display = "none";
                icon.classList.remove("rotate");
            } else {
                menu.style.display = "block";
                icon.classList.add("rotate");
            }
        }
    </script>