
<?php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;

    $user = Auth::user();
    $adminName = $user->name ?? (session('admin_firstname') ?? 'Administrator');
    $onDashboard = request()->routeIs('admin.dashboard');

    // Items
    $dashboardItem = [
        'label' => 'Dashboard',
        'icon'  => '🏠',
        'route' => 'admin.dashboard',
        'active'=> request()->routeIs('admin.dashboard'),
        'exists'=> Route::has('admin.dashboard'),
    ];

    $navLinks = [
        [
            'label' => 'User Complaints',
            'icon'  => '📊',
            'route' => 'admin.reports',
            'active'=> request()->routeIs('admin.reports'),
            'exists'=> Route::has('admin.reports'),
        ],
        [
            'label' => 'Accounts',
            'icon'  => '👥',
            'route' => 'admin.accounts',
            'active'=> request()->routeIs('admin.accounts'),
            'exists'=> Route::has('admin.accounts'),
        ],
        [
            'label' => 'Add Partnership',
            'icon'  => '🤝',
            'route' => 'admin.partnerships',
            'active'=> request()->routeIs('admin.partnerships*'),
            'exists'=> Route::has('admin.partnerships'),
        ],
        [
            'label' => 'AI Chatbot',
            'icon'  => '🤖',
            'route' => 'admin.chatbot',
            'active'=> request()->routeIs('admin.chatbot'),
            'exists'=> Route::has('admin.chatbot'),
        ],
    ];

    $analytics = [
    'label' => 'Analytics',
    'icon'  => '📈',
    'route' => 'admin.analytics',
    'active'=> request()->routeIs('admin.analytics'),
    'exists'=> Route::has('admin.analytics'),
    ];

    // Sidebar items:
    // - On dashboard: ONLY Profile
    // - Else: Dashboard + 4 pages + Profile
    if ($onDashboard) {
        $sidebarItems = array_values(array_filter(
            [$analytics],
            fn($i) => !empty($i['exists']) && $i['exists']
        ));
    } else {
        $sidebarItems = array_values(array_filter(
            array_merge([$dashboardItem], $navLinks, [$analytics]),
            fn($i) => !empty($i['exists']) && $i['exists']
        ));
    }

    // Mobile: always Dashboard + 4 pages + Profile
    $mobileItems = array_values(array_filter(
        array_merge([$dashboardItem], $navLinks, [$analytics]),
        fn($i) => !empty($i['exists']) && $i['exists']
    ));
?>


<aside class="hidden lg:flex fixed left-0 top-0 h-screen w-60 bg-white border-r border-slate-200 px-4 py-6 z-50">
    <div class="w-full flex flex-col gap-2">
        
        <div class="px-3 pb-5 border-b border-slate-200">
            <?php if (isset($component)) { $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown','data' => ['align' => 'left','width' => '48']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['align' => 'left','width' => '48']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                 <?php $__env->slot('trigger', null, []); ?> 
                    <button type="button"
                        class="w-full flex items-center justify-between gap-2 rounded-xl px-3 py-2
                               text-blue-600 font-semibold text-sm hover:bg-blue-50 transition">
                        <span class="truncate"><?php echo e($adminName); ?></span>
                        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                 <?php $__env->endSlot(); ?>

                 <?php $__env->slot('content', null, []); ?> 
                    <form method="POST" action="<?php echo e(url('/logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => url('/logout'),'onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(url('/logout')),'onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                            Log Out
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                    </form>
                 <?php $__env->endSlot(); ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $attributes = $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $component = $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>

            <div class="text-xs text-slate-500 mt-2 px-3">Administrator</div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $sidebarItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <a href="<?php echo e(route($item['route'])); ?>"
               class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
               <?php echo e(!empty($item['active']) && $item['active'] ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'); ?>">
                <span><?php echo e($item['icon']); ?></span>
                <span class="font-semibold"><?php echo e($item['label']); ?></span>
            </a>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>
</aside>


<nav class="lg:hidden fixed bottom-4 left-1/2 -translate-x-1/2 w-[min(520px,calc(100%-1.5rem))] bg-white/95 backdrop-blur border border-slate-200 shadow-xl rounded-2xl px-3 py-2 z-50">
    <div class="flex items-center justify-between">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $mobileItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <a href="<?php echo e(route($item['route'])); ?>"
               class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
               <?php echo e(!empty($item['active']) && $item['active'] ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-black'); ?>">
                <span class="text-xl leading-none"><?php echo e($item['icon']); ?></span>
                <span class="text-[11px] font-semibold"><?php echo e($item['label']); ?></span>
            </a>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>
</nav><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/partials/admin-nav.blade.php ENDPATH**/ ?>