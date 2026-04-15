
<aside class="hidden lg:flex fixed left-0 top-0 h-screen w-60 bg-white border-r border-slate-200 px-4 py-6 z-50">
    <div class="w-full flex flex-col gap-2">
        <div class="px-3 pb-5 border-b border-slate-200">
    
    <!-- <div class="text-lg font-extrabold text-blue-600">
        RentConnect
    </div> -->

    <?php
        $landlord = \App\Models\Landlord::find(session('landlord_id'));

        $landlordUnreadCount = 0;

        if ($landlord) {
            $landlordUnreadCount = \App\Models\Message::where('landlordid', $landlord->id)
                ->where('sender_type', '!=', 'landlord')
                ->where('is_read_by_landlord', false)
                ->count();
        }
    ?>

    
    <div class="mt-2">
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
                    class="w-full flex items-center justify-between gap-2 rounded-xl px-3 py-1
                           text-blue-600 font-semibold text-lg font-bold hover:bg-blue-50 transition">
                    <span class="truncate"><?php echo e(Auth::user()->name); ?></span>

                    <svg class="h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
             <?php $__env->endSlot(); ?>

             <?php $__env->slot('content', null, []); ?> 
                <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('profile.edit')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('profile.edit'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                    <?php echo e(__('Profile')); ?>

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

                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('logout'),'onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('logout')),'onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                        <?php echo e(__('Log Out')); ?>

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
    </div>

    
    <div class="text-xs text-slate-500 mt-2 px-3">
        Landlord
    </div>
</div>


        <a href="<?php echo e(route('landlord.dashboard')); ?>"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
           <?php echo e(request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'); ?>">
            <span>🏠</span>
            <span class="font-semibold">Home</span>
        </a>

        <a href="<?php echo e(route('landlord.messages')); ?>"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
           <?php echo e(request()->routeIs('landlord.messages') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'); ?>">
            <span>💬</span>
            <span class="font-semibold">Messages</span>
        
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($landlordUnreadCount > 0): ?>
                <span class="inline-flex items-center justify-center min-w-[20px] h-[20px] rounded-full bg-red-500 px-1.5 text-[11px] font-semibold text-white">
                    <?php echo e($landlordUnreadCount); ?>

                </span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
        </a>

        <a href="<?php echo e(route('landlord.support')); ?>"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
           <?php echo e(request()->routeIs('landlord.support') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'); ?>">
            <span>🛟</span>
            <span class="font-semibold">Support</span>
        </a>

        <a href="<?php echo e(route('profile.edit')); ?>"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
           <?php echo e(request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'); ?>">
            <span>👤</span>
            <span class="font-semibold">Profile</span>
        </a>
    </div>
</aside>


<nav class="lg:hidden fixed bottom-4 left-1/2 -translate-x-1/2 w-[min(520px,calc(100%-1.5rem))] bg-white/95 backdrop-blur border border-slate-200 shadow-xl rounded-2xl px-3 py-2 z-50">
    <div class="flex items-center justify-between">
        <a href="<?php echo e(route('dashboard')); ?>"
           class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
           <?php echo e(request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-slate-900'); ?>">
            <span>🏠</span>
            <span class="text-[11px] font-semibold">Home</span>
        </a>

        <a href="<?php echo e(route('landlord.messages')); ?>"
           class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
           <?php echo e(request()->routeIs('landlord.messages') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-slate-900'); ?>">
            <span>💬</span>
            <span class="text-[11px] font-semibold">Chat</span>
        </a>

        <a href="<?php echo e(route('landlord.support')); ?>"
           class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
           <?php echo e(request()->routeIs('landlord.support') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-slate-900'); ?>">
            <span>🛟</span>
            <span class="text-[11px] font-semibold">Support</span>
        </a>

        <a href="<?php echo e(route('profile.edit')); ?>"
           class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
           <?php echo e(request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-slate-900'); ?>">
            <span>👤</span>
            <span class="text-[11px] font-semibold">Profile</span>
        </a>
    </div>
</nav>
<?php /**PATH C:\Users\moyak\final-year-project-gracemoore1\resources\views/partials/landlord-nav.blade.php ENDPATH**/ ?>