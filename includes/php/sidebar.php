<div class="sidebar flex-shrink-3 p-3 " style="width: 220px;">
    <ul class="list-unstyled ps-0">
      <li>
        <button class="btn btn-toggle align-items-center rounded collapsed" >
        <a href="dashboard.php" class="link-light rounded"> 
            <?php echo $lang["Dashboard"];?>  
        </a>  
        </button>
        <div class="collapse" id="home-collapse" style="">
        </div>
      </li>
      <li>
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Invoices-collapse" aria-expanded="false">
            <?php echo $lang["Invoices"];?>  
        </button>
        <div class="collapse" id="Invoices-collapse" style="">
          <ul class="btn-toggle-nav fw-normal pb-1 small">
            <li>
              <a href="#" class="link-light rounded">
                <?php echo $lang["Create invoice"];?>
              </a>
            </li>
            <li>
              <a href="all_invoices.php" class="link-light rounded">
                <?php echo $lang["All Invoices"];?>
              </a>
            </li>
            <li>
              <a href="selling_invoices.php" class="link-light rounded">
                <?php echo $lang["Selling"];?>
              </a>
            </li>
            <li>
              <a href="return_invoices.php" class="link-light rounded">
                <?php echo $lang["Return"];?>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li>
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Medicines-collapse" aria-expanded="false">
          <?php echo $lang["Medicines"];?>
        </button>
        <div class="collapse" id="Medicines-collapse">
          <ul class="btn-toggle-nav fw-normal pb-1 small">
            <li>
              <a href="#" class="link-light rounded">
                <?php echo $lang["Add medicine"];?>
              </a>
            </li>
            <li>
              <a href="#" class="link-light rounded">
                <?php echo $lang["View medicine"];?>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li>
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Inventory-collapse" aria-expanded="false">
        <?php echo $lang["Inventory"];?>  
        </button>
      </li>
      <li>
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Purchases-collapse" aria-expanded="false">
          <?php echo $lang["Purchases"];?>
        </button>
        <div class="collapse" id="Purchases-collapse">
          <ul class="btn-toggle-nav fw-normal pb-1 small">
            <li>
              <a href="#" class="link-light rounded">
                <?php echo $lang["Create purchase invoice"];?>
              </a>
            </li>
            <li>
              <a href="#" class="link-light rounded">
                <?php echo $lang["View purchase invoices"];?>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li>
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Expenses-collapse" aria-expanded="false">
          <?php echo $lang["Expenses"];?>
        </button>
        <div class="collapse" id="Expenses-collapse">
          <ul class="btn-toggle-nav fw-normal pb-1 small">
            <li>
              <a href="#" class="link-light rounded">
                <?php echo $lang["Add expense"];?>
              </a>
            </li>
            <li>
              <a href="#" class="link-light rounded">
                <?php echo $lang["View expenses"];?>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li>
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Customers-collapse" aria-expanded="false">
          <?php echo $lang["Customers"];?>
        </button>
        <div class="collapse" id="Customers-collapse">
          <ul class="btn-toggle-nav fw-normal pb-1 small">
            <li>
              <a href="add_customers.php" class="link-light rounded">
                <?php echo $lang["Add customer"];?>
              </a>
            </li>
            <li>
              <a href="view_customers.php" class="link-light rounded">
                <?php echo $lang["View customers"];?>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li>
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Employees-collapse" aria-expanded="false">
          <?php echo $lang["Employees"];?>
        </button>
        <div class="collapse" id="Employees-collapse">
          <ul class="btn-toggle-nav fw-normal pb-1 small">
            <li>
              <a href="#" class="link-light rounded">
                <?php echo $lang["Add Employee"];?>
              </a>
            </li>
            <li>
              <a href="#" class="link-light rounded">
                <?php echo $lang["View Employee"];?>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li>
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Suppliers-collapse" aria-expanded="false">
          <?php echo $lang["Suppliers"];?>
        </button>
        <div class="collapse" id="Suppliers-collapse">
          <ul class="btn-toggle-nav fw-normal pb-1 small">
            <li>
              <a href="#" class="link-light rounded">
                <?php echo $lang["Add supplier"];?>
              </a>
            </li>
            <li>
              <a href="#" class="link-light rounded">
                <?php echo $lang["View suppliers"];?>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li>
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Manufactures-collapse" aria-expanded="false">
          <?php echo $lang["Manufactures"];?>
        </button>
        <div class="collapse" id="Manufactures-collapse">
          <ul class="btn-toggle-nav fw-normal pb-1 small">
            <li>
              <a href="#" class="link-light rounded">
                <?php echo $lang["Add manufacture"];?>
              </a>
            </li>
            <li>
              <a href="#" class="link-light rounded">
                <?php echo $lang["View manufacture"];?>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li>
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Settings-collapse" aria-expanded="false">
          <?php echo $lang["Settings"];?>
        </button>
        <div class="collapse" id="Settings-collapse">
          <ul class="btn-toggle-nav fw-normal pb-1 small">
            <li>
              <a href="#" class="link-light rounded">
                <?php echo $lang["Change theme"];?>
              </a>
            </li>
            <li>
              <a href="#" class="link-light rounded">
                <?php echo $lang["Reset system"];?>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li>
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Profile-collapse" aria-expanded="false">
          <?php echo $lang["Profile"];?>
        </button>
        <div class="collapse" id="Profile-collapse">
          <ul class="btn-toggle-nav fw-normal pb-1 small">
            <li>
              <a href="#" class="link-light rounded">
                <?php echo $lang["Profile informations"];?>
              </a>
            </li>
            <li>
              <a href="#" class="link-light rounded">
                <?php echo $lang["Logout"];?>
              </a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>