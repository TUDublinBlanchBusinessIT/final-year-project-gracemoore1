
<?php
    use Illuminate\Support\Facades\Route;

    // Name from session (same key as dashboard header)
    $spName = session('serviceprovider_firstname') ?? 'Service Provider';

    // Build nav items (always show on dashboard too)
    $items = [
        [
            'label' => 'Upcoming Jobs',
            'route' => 'serviceprovider.upcoming',
            'active'=> request()->routeIs('serviceprovider.upcoming'),
            'exists'=> Route::has('serviceprovider.upcoming'),
            'svg'   => 'calendar',
        ],
        [
            'label' => 'Completed Jobs',
            'route' => 'serviceprovider.completed',
            'active'=> request()->routeIs('serviceprovider.completed'),
            'exists'=> Route::has('serviceprovider.completed'),
            'svg'   => 'check',
        ],
        [
            'label' => 'Requested Jobs',
            'route' => 'serviceprovider.requested',
            'active'=> request()->routeIs('serviceprovider.requested'),
            'exists'=> Route::has('serviceprovider.requested'),
            'svg'   => 'document',
        ],
        [
            'label' => 'Messages',
            'route' => 'serviceprovider.messages',
            'active'=> request()->routeIs('serviceprovider.messages'),
            'exists'=> Route::has('serviceprovider.messages'),
            'svg'   => 'chat',
        ],
    ];

    $items = array_values(array_filter($items, fn($i) => !empty($i['exists']) && $i['exists']));

    // Small helper for SVG icons
    $icon = function(string $name) {
        return match ($name) {
            'home' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5L12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1v-10.5z"/>
                       </svg>',
            'calendar' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M8 2v3M16 2v3"/>
                             <path stroke-linecap="round" stroke-linejoin="round" d="M3 9h18"/>
                             <rect x="3" y="5" width="18" height="17" rx="2" ry="2"></rect>
                           </svg>',
            'check' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/>
                        </svg>',
            'document' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l3 3v15a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"/>
                             <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                           </svg>',
            'chat' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8z"/>
                       </svg>',
            default => '',
        };
    };
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
                 <?php $__env->slot('trigger', null, []); ?> 
                    <button type="button"
                        class="w-full flex items-center justify-between gap-2 rounded-xl px-3 py-2
                               text-blue-600 font-semibold text-lg hover:bg-blue-50 transition">
                        <span class="truncate"><?php echo e($spName); ?></span>
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

            <div class="text-xs text-slate-500 mt-1 px-3">Service Provider</div>
        </div>

        
        <nav class="mt-2 flex flex-col gap-1">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route($item['route'])); ?>"
                   class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
                   <?php echo e(!empty($item['active']) && $item['active'] ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'); ?>">
                    <span class="<?php echo e(!empty($item['active']) && $item['active'] ? 'text-blue-600' : 'text-slate-500'); ?>"><?php echo $icon($item['svg']); ?></span>
                    <span><?php echo e($item['label']); ?></span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </nav>
    </div>
</aside>


<nav class="lg:hidden fixed bottom-4 left-1/2 -translate-x-1/2 w-[min(520px,calc(100%-1.5rem))] bg-white/95 backdrop-blur border border-slate-200 shadow-xl rounded-2xl px-3 py-2 z-50">
    <div class="flex items-center justify-between">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route($item['route'])); ?>"
               class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
               <?php echo e(!empty($item['active']) && $item['active'] ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-black'); ?>">
                <span class="leading-none"><?php echo $icon($item['svg']); ?></span>
                <span class="text-[11px] font-semibold"><?php echo e($item['label']); ?></span>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</nav><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/partials/serviceprovider-nav.blade.php ENDPATH**/ ?>