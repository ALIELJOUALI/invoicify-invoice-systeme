<style>
    .btn2 {
        margin-right: 10px; /* Add margin to the right of the button */
    }
</style>

<ul class="nav navbar-nav flex-row">
    <li class="dropdown">
        <button class="btn2 btn-primary dropdown-toggle border-0" type="button" data-toggle="dropdown">Operations
        <span class="caret"></span></button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="invoice_list.php">Invoice List</a></li>
            <li><a class="dropdown-item" href="create_invoice.php">Create Invoice</a></li>                  
        </ul>
    </li>
    <?php 
    if($_SESSION['userid']) { ?>
        <li class="dropdown">
            <button class="btn2 btn-secondary dropdown-toggle border-0" type="button" data-toggle="dropdown"><?php echo $_SESSION['user']; ?>
            <span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="action.php?action=logout">Logout</a></li>         
            </ul>
        </li>
    <?php } ?>
</ul>
<br /><br /><br />
