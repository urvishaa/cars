<?php $__env->startSection('content'); ?>
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();
?>

<?php //echo '<pre>'; print_r($result); die; ?>
    <section class="section-padding rent-car-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title  text-center sthowroom-detail">
                       <div class="show-ret"> 
                          <h2><?php echo e(trans('labels.companyAdminList')); ?></h2>
                       </div>
                        <div >
                            <p style="font-weight: 600; margin-bottom: 15px; color: red; margin-top: 0px;"><?php echo e(trans('labels.registrationContact')); ?></p>
                        </div>
                       <div class="show-select">
                             
                              <select onchange="ddfilter()" id="filter" name="filter">
                              <option value="" ><?php echo e(trans('labels.selectCity')); ?></option>
                                <?php $__empty_1 = true; $__currentLoopData = $result['city']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                      <option value="<?php echo e($city->id); ?>"  <?php if(isset($result['filters']) AND $result['filters'] == @$city->id): ?> selected <?php endif; ?> > <?php if(isset($session['language']) AND $session['language']=='ar'): ?> <?php echo e($city->ar); ?> <?php elseif(isset($session['language']) AND $session['language']=='ku'): ?> <?php echo e($city->ku); ?> <?php else: ?> <?php echo e($city->name); ?> <?php endif; ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                <?php endif; ?>
                            </select>
                          
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                   
                        <?php if(count($result['companyAdmins'])): ?>
                            <?php $__currentLoopData = $result['companyAdmins']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $companyAdmin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6">
                            
                                <div class="img_real_home Car-rent form-group">
                                    <div class="img_real">
                                       <a href="<?php echo e(URL::to('/companyList/'.$companyAdmin->myid)); ?>">
                                        <img src="<?php echo e($companyAdmin->image ? $new.'/'.$companyAdmin->image : url('/public/default-image.jpeg' )); ?>">
                                      </a>
                                    </div>
                                        <div class="real_content">
                                    
                                            <div class="estate_real">
                                                <ul class="esta_ul">
                                                <?php if($companyAdmin->first_name !='' || $companyAdmin->last_name != ''): ?>                                                 
                                                    <li class="esta_li">
                                                        <a href="<?php echo e(URL::to('/companyList/'.$companyAdmin->myid)); ?>"><?php echo e($companyAdmin->first_name); ?> <?php echo e($companyAdmin->last_name); ?></a>
                                                        
                                                    </li>
                                                <?php endif; ?>
                                                <?php if($companyAdmin->phone !=''): ?> 

                                                    <li class="esta_li telp">
                                                        <a href="tel:<?php echo e($companyAdmin->phone); ?>">
                                                            <label><i class="fa fa-mobile-alt"></i></label><span><?php echo e($companyAdmin->phone); ?></span>
                                                        </a>
                                                        
                                                    </li>
                                                <?php endif; ?>
                                                <?php if($companyAdmin->email !=''): ?> 

                                                    <li class="esta_li telp">
                                                        <a href="mailto:<?php echo e($companyAdmin->email); ?>"><label><i class="far fa-envelope"></i></label><span><?php echo e($companyAdmin->email); ?></span></a>
                                                    </li> 
                                                <?php endif; ?>  

                                                <?php if($companyAdmin->city !=''): ?> 

                                                    <li class="esta_li telp">
                                                        <a><label><i class="fas fa-map-marker-alt"></i></label>
                                                          <span><?php $__empty_1 = true; $__currentLoopData = $result['city']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                                                <?php if(isset($companyAdmin->city) AND $companyAdmin->city == @$city1->id): ?>  <?php if(isset($session['language']) AND $session['language']=='ar'): ?> <?php echo e($city1->ar); ?> <?php elseif(isset($session['language']) AND $session['language']=='ku'): ?> <?php echo e($city1->ku); ?> <?php else: ?> <?php echo e($city1->name); ?> <?php endif; ?> <?php endif; ?>
                                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                                          <?php endif; ?></span>
                                                        </a>
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
                    <div style="margin-top: 15px;"><?php echo e(@$result['companyAdmins']->links('vendor.pagination.default')); ?></div> 
                    <div class="col-xs-12 text-right">
                      
                    </div>
                </div>
    </section>
<script type="text/javascript">
     function ddfilter(){
      var fil = document.getElementById("filter").value;
      var url='<?php echo e(URL::to("/companyadminlist")); ?>';

     var urls=url+'?filter='+fil;
      window.location.href=urls;
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>