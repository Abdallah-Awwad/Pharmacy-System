
    <?php include "../includes/php/header.php";?>
    <div class="main-page" id="mainPage">

        <!-- Start of dashboard -->
        <div class="dasbhoard">

            <!-- Title -->
            <h1>
                <span><?php echo $lang["Dashboard"];?></span>
            </h1>

            <!-- Start First Row -->
            <div class="row statistics text-center">

                <div class="col sales">
                    <div class="number">
                        1.00
                    </div>
                    <div class="description">
                        <?php echo $lang["Today total sales"];?>
                    </div>
                    <div class="more-info">
                        <a href="#">
                            <span>
                                <?php echo $lang["More info"];?> <i class="fa-solid <?php echo $lang["fa-circle-arrow-right"];?>"></i>
                            </span>
                        </a>

                    </div>
                </div>

                <div class="col expenses">
                    <div class="number">
                        0.00
                    </div>
                    <div class="description">
                        <?php echo $lang["Today total expenses"];?> 
                    </div>
                    <div class="more-info">
                        <a href="#">
                            <span>
                                <?php echo $lang["More info"];?> <i class="fa-solid <?php echo $lang["fa-circle-arrow-right"];?>"></i>
                            </span>
                        </a>
                    </div>
                </div>

                <div class="col returns">
                    <div class="number">
                        0.00
                    </div>
                    <div class="description">
                        <?php echo $lang["Today total returns"];?>
                    </div>
                    <div class="more-info"> 
                        <a href="#">
                            <span>
                                <?php echo $lang["More info"];?> <i class="fa-solid <?php echo $lang["fa-circle-arrow-right"];?>"></i>
                            </span>
                        </a>
                    </div>
                </div>

                <div class="col expiry">
                    <div class="number">
                        0.00
                    </div>
                    <div class="description">
                        <?php echo $lang["Near expiry products"];?>
                    </div>
                    <div class="more-info">
                        <a href="#">
                            <span>
                                <?php echo $lang["More info"];?> <i class="fa-solid <?php echo $lang["fa-circle-arrow-right"];?>"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- End First Row -->

            <!-- Start Second Row -->
            <div class="shortcuts row justify-content-around">
                <div class="col-5">
                    <h2><?php echo $lang["Quick Stats"];?></h2>
                    <p>
                        - <?php echo $lang["Number of products"];?> 
                        <span>00</span>
                    </p>
                    <p>
                        - <?php echo $lang["New customers this week"];?>
                        <span>00</span>
                    </p>
                </div>

                <div class="col-5">
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="col-6 text-center">
                            <h2><?php echo $lang["Make invoice"];?></h2>
                        </div>
        
                        <div class="col">
                    </div>
                    <img src="../imgs/invoice3.svg" class="img-fluid rounded mx-auto d-block" alt="..." width="200">    
                    </div>
                </div>

                <div class="col-5">
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="col-6 text-center">
                            <h2><?php echo $lang["Update the stock"];?></h2>
                        </div>
        
                        <div class="col">
                    </div>
                    <img src="../imgs/barcode.jpg" class="img-fluid rounded mx-auto d-block" alt="..." width="150">    
                    </div>
                </div>


                <div class="col-5">
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="col-6 text-center">
                            <h2><?php echo $lang["Add a new medicine"];?></h2>
                        </div>
        
                        <div class="col">
                    </div>
                    <img src="../imgs/medicine.jpg" class="img-fluid rounded mx-auto d-block" alt="..." width="150">    
                    </div>
                </div>

            </div>
            <!-- End Second Row -->


        </div>    
        <!-- End of dashboard -->
    </div> 


    <?php include "../includes/php/footer.php";?>