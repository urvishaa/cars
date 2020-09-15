<?php $__env->startSection('content'); ?>
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
// echo '<pre>'; print_r($result['book']);die;
?>

<div class="myordr-list section-padding">
    <div class="container">
        <div class="row">
            <!-- Section Title Start -->
            <div class="col-lg-12">
                <div class="section-title  text-center">
                    <h2><?php echo e(trans('labels.carBookList')); ?></h2>
                    <span class="title-line"><i class="fa fa-car"></i></span>
                </div>
            </div>
            <!-- Section Title End -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php if(Session::has('message')): ?>
                    <div class="alert alert-info">
                        <p><?php echo e(Session::get('message')); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div> 
        <div class="row">       
            <div class="col-lg-12 bg-white rounded shadow-sm">  
               
                <div class="table-responsive prolisttabcls">
                    <table class="table" >
                        <thead>
                            <tr>                        
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.bookingId')); ?></div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.carName')); ?></div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.carBrand')); ?></div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.carModel')); ?></div></th>
                              
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.dateFrom')); ?></div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.dateTo')); ?></div></th>
                            
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.action')); ?></div></th>
                            </tr>
                        </thead>       
                            <tbody>
                            <?php if(count($result['book']) > 0): ?>
                                <?php $__currentLoopData = $result['book']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <?php if($book->prop_category != '' AND $book->prop_category > 0): ?>
                                        <?php @$carmodel = DB::table('car_model')->where('id',@$book->prop_category)->first(); ?>
                                    <?php endif; ?>

                                    <?php if($book->car_brand != '' AND $book->car_brand > 0): ?>
                                        <?php @$carbrand = DB::table('car_brand')->where('id',@$book->car_brand)->first(); ?>
                                    <?php endif; ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <?php echo e('#'); ?><?php echo e($book->id); ?>

                                        </td>
                                        <td class="align-middle text-center">
                                           <a href="<?php echo e(URL::to('/rentalcar_detail/'.$book->carId)); ?>"> <?php echo e(@$book->car_name); ?> </a>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo e(@$carbrand->name); ?>

                                        </td>
                                         <td class="align-middle text-center">
                                            
                                            <?php echo e(@$carmodel->name); ?>

                                       
                                        </td>
                                        <td class="align-middle text-center">                        
                                            <?php echo e($book->dateFrom); ?>


                                        </td>
                                        <td class="align-middle text-center">                        
                                            <?php echo e($book->dateTo); ?>


                                        </td>
                                        
                                        <td class="align-middle text-center">
                                            <a href="<?php echo e(url('/book-detail/'.base64_encode($book->id))); ?>" class="btn btn-primary"><?php echo e(trans('labels.detail')); ?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7">
                                        <center><h5><?php echo e(trans('labels.noResultFound')); ?></h5></center>
                                    </td>
                                </tr>
                            <?php endif; ?>                   
                            </tbody>
                    </table>
                </div>    
                <?php if(count($result['book']) > 0): ?>           
                      <?php echo e($result['book']->links('vendor.pagination.default')); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>