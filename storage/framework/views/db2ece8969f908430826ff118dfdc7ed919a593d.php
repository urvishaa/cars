<?php $request = app('Illuminate\Http\Request'); ?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">
             

                <li class="<?php echo e($request->segment(2) == 'dashboard' ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/dashboard')); ?>">
                        <i class="fa fa-wrench"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>                 
               
                <li class="<?php echo e($request->segment(2) == 'program_level' ? 'active active-sub' : ''); ?>">
                        <a href="<?php echo e(url('admin/program_level')); ?>">
                            <i class="fa fa-briefcase"></i>
                            <span class="title">
                                Program Level
                            </span>
                        </a>
                </li>
                
               
                <li class="<?php echo e($request->segment(2) == 'programs' ? 'active active-sub' : ''); ?>">
                        <a href="<?php echo e(url('admin/programs')); ?>">
                             <i class="fa fa-tasks"></i>
                            <span class="title">
                                Programs
                            </span>
                        </a>
                </li>

                <li class="<?php echo e($request->segment(2) == 'users' ? 'active active-sub' : ''); ?>">
                        <a href="<?php echo e(url('admin/users')); ?>">
                                <i class="fa fa-user"></i>
                            <span class="title">
                                Users
                            </span>
                        </a>
                </li>

                <li class="<?php echo e($request->segment(2) == 'blog' ? 'active active-sub' : ''); ?>">
                        <a href="<?php echo e(url('admin/blog')); ?>">
                                <i class="fab fa-blogger-b"></i> 
                            <span class="title">
                                Blog
                            </span>
                        </a>
                </li>

                <li class="<?php echo e($request->segment(2) == 'userreview' ? 'active active-sub' : ''); ?>">
                        <a href="<?php echo e(url('admin/userreview')); ?>">
                                <i class="fas fa-star"></i> 
                            <span class="title">
                                Review
                            </span>
                        </a>
                </li>

                <li class="<?php echo e($request->segment(2) == 'appartreview' ? 'active active-sub' : ''); ?>">
                        <a href="<?php echo e(url('admin/appartreview')); ?>">
                                <i class="fas fa-star"></i> 
                            <span class="title">
                                Housing Review
                            </span>
                        </a>
                </li>




                <li class="<?php echo e($request->segment(2) == 'educations' ? 'active active-sub' : ''); ?>">
                    <a href="<?php echo e(url('admin/educations')); ?>">
                        <i class="fa fa-graduation-cap"></i>

                        <span class="title">
                            Educations
                        </span>
                    </a>
                </li>


                <li class="<?php echo e($request->segment(2) == 'appartment' ? 'active active-sub' : ''); ?>">
                    <a href="<?php echo e(url('admin/appartment')); ?>">
                        <i class="fa fa-building"></i>
                        <span class="title">
                            Appartment
                        </span>
                    </a>
                </li>

                <li class="<?php echo e($request->segment(2) == 'article' ? 'active active-sub' : ''); ?>">
                    <a href="<?php echo e(url('admin/article')); ?>">
                    <i class="far fa-newspaper"></i>
                        <span class="title">
                            Article
                        </span>
                    </a>
                </li>


                <li class="<?php echo e($request->segment(2) == 'setting' ? 'active active-sub' : ''); ?>">
                    <a href="<?php echo e(url('admin/setting')); ?>">
                           <i class="fa fa-cog"></i>
                        <span class="title">
                            Setting
                        </span>
                    </a>
                </li>  

                <li class="<?php echo e($request->segment(1) == 'change_password' ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('/change_password')); ?>">
                        <i class="fa fa-key"></i>
                        <span class="title">Change Password</span>
                    </a>
                </li>

                <li>
                    <a href="/schoolpro/logout">
                        <i class="fa fa-arrow-left"></i>
                        <span class="title">Logout</span>
                    </a>
                </li>
        </ul>
    </section>
</aside>

