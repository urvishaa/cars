<?php $__env->startSection('content'); ?>
    <style>
      section.buyonecls {
        margin-top: 120px;
        margin-bottom: 30px;
      }
    </style>

    <main id="main">
    <section class="buyonecls">
       <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Shipping Detail</div>
                        <div class="card-body">

                            <form class="form-horizontal" method="post" action="<?php echo e(URL::to('/saveorder')); ?>">

                                <div class="form-group">
                                    <label for="name" class="cols-sm-2 control-label">Product Name </label>
                                    <div class="cols-sm-10">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="pro_name" id="Pro_name" value="DIET PLAN ONLYS" required="required" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="cols-sm-2 control-label">Product Price </label>
                                    <div class="cols-sm-10">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="pro_price" id="Pro_price" value="1" required="required" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="cols-sm-2 control-label">First Name</label>
                                    <div class="cols-sm-10">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="fname" id="fname" required="required" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="cols-sm-2 control-label">Last Name</label>
                                    <div class="cols-sm-10">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="lname" id="lname" required="required" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="cols-sm-2 control-label">Company</label>
                                    <div class="cols-sm-10">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="company" id="company" required="required" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="cols-sm-2 control-label">Address</label>
                                    <div class="cols-sm-10">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="address" id="address" required="required" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="cols-sm-2 control-label">Your Email</label>
                                    <div class="cols-sm-10">
                                        <div class="input-group">
                                            <input type="email" class="form-control" name="email" id="email"  required="required" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="username" class="cols-sm-2 control-label">Phone Number</label>
                                    <div class="cols-sm-10">
                                        <div class="input-group">
                                          <input type="text" class="form-control" name="phone" id="phone" required="required" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block login-button">Order Now</button>
                                </div>
                                
                            </form>
                        </div>

                    </div>
                </div>
            </div>

      </div>
    </section>

  <?php $__env->stopSection(); ?> 


<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>