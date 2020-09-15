<?php $__env->startSection('content'); ?>
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();

  
?>



    <section class="section-padding rent-car-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title  text-center sthowroom-detail">
                       <div class="show-ret"> 
                          <h2><?php echo e(trans('labels.showroomList')); ?></h2>
                       </div>
                       <div >
                            <p style="font-weight: 600; color: red; margin-top: 10px; margin-bottom: 15px;"><?php echo e(trans('labels.registrationContact')); ?></p>
                        </div>
                       <?php // echo '<pre>'; print_r($session); die; ?>
                       <div class="show-select">
                             
                            <select  onchange="ddfilter()" id="filter" name="filter">
                              <option value=""><?php echo e(trans('labels.selectCity')); ?></option>

                                <?php $__empty_1 = true; $__currentLoopData = $result['city']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 

                                      <option value="<?php echo e($city->id); ?>" <?php if(isset($result['filters']) AND $result['filters'] == @$city->id): ?> selected <?php endif; ?>> <?php if(isset($session['language']) AND $session['language']=='ar'): ?> <?php echo e($city->ar); ?> <?php elseif(isset($session['language']) AND $session['language']=='ku'): ?> <?php echo e($city->ku); ?> <?php else: ?> <?php echo e($city->name); ?> <?php endif; ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                <?php endif; ?>
                            </select>
                          
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                   
                    <?php if(count($result['showRoomAdmins'])): ?>
                        <?php $__currentLoopData = $result['showRoomAdmins']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $showRoomAdmin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6">
                        
                                <div class="img_real_home Car-rent form-group">
                                    <div class="img_real">
                                      <a href="<?php echo e(URL::to('/showroomList/'.$showRoomAdmin->myid)); ?>">
                                        <img src="<?php echo e($showRoomAdmin->image ? $new.'/'.$showRoomAdmin->image : url('/public/default-image.jpeg' )); ?>">
                                        </a>
                                    </div>
                                    <div class="real_content">
                                
                                        <div class="estate_real">
                                            <ul class="esta_ul">
                                            <?php if($showRoomAdmin->first_name !='' || $showRoomAdmin->last_name != ''): ?>                                                 
                                                <li class="esta_li">
                                                    <a href="<?php echo e(URL::to('/showroomList/'.$showRoomAdmin->myid)); ?>"><?php echo e($showRoomAdmin->first_name); ?> <?php echo e($showRoomAdmin->last_name); ?></a>
                                                    
                                                </li>
                                            <?php endif; ?>
                                            <?php if($showRoomAdmin->phone !=''): ?> 

                                                <li class="esta_li telp">
                                                    <a href="tel:<?php echo e($showRoomAdmin->phone); ?>">
                                                        <label><i class="fa fa-mobile-alt"></i></label><span><?php echo e($showRoomAdmin->phone); ?></span>
                                                    </a>
                                                    
                                                </li>
                                            <?php endif; ?>
                                            <?php if($showRoomAdmin->email !=''): ?> 

                                                <li class="esta_li telp">
                                                    <a href="mailto:<?php echo e($showRoomAdmin->email); ?>"><label><i class="far fa-envelope"></i></label><span><?php echo e($showRoomAdmin->email); ?></span></a>
                                                </li> 
                                            <?php endif; ?>    
                                            <?php if($showRoomAdmin->city !=''): ?> 

                                                <li class="esta_li telp">
                                                    <a><label><i class="fas fa-map-marker-alt"></i></label><span>
                                                       <?php $__empty_1 = true; $__currentLoopData = $result['city']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                                            <?php if(isset($showRoomAdmin->city) AND $showRoomAdmin->city == @$city1->id): ?>  <?php if(isset($session['language']) AND $session['language']=='ar'): ?> <?php echo e($city1->ar); ?> <?php elseif(isset($session['language']) AND $session['language']=='ku'): ?> <?php echo e($city1->ku); ?> <?php else: ?> <?php echo e($city1->name); ?> <?php endif; ?> <?php endif; ?>
                                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                                      <?php endif; ?>
                                                    </span></a>
                                                </li> 
                                            <?php endif; ?>                         
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <p style=" width: 100%;display: flex;justify-content: center;align-content: center;"><?php echo e(trans('labels.noResultFound')); ?></p>
                    <?php endif; ?>
                    </div>
                    <div style="margin-top: 25px;"><?php echo e($result['showRoomAdmins']->links('vendor.pagination.default')); ?></div>
                    <div class="col-xs-12 text-right">
                    </div>
                </div>
   
    </section>
<script type="text/javascript">
 function ddfilter(){
  var fil = document.getElementById("filter").value;
  var url='<?php echo e(URL::to("/showroomlist")); ?>';

 var urls=url+'?filter='+fil;
  window.location.href=urls;
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>