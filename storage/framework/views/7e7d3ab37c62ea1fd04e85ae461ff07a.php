<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<?php
    $authUser = Auth::user();

    $authRole = $authUser->role ?? null;

    // Keep support for old custom sessions
    $studentSession = session('student_id');
    $landlordSession = session('landlord_id');
    $adminSession = session('admin_id');
    $serviceProviderSession = session('serviceprovider_id');

    // Student + landlord can come from Auth role OR session
    $isStudent = $authRole === 'student' || $studentSession;
    $isLandlord = $authRole === 'landlord' || $landlordSession;

    // Admin + service provider still rely on session
    $isAdmin = !empty($adminSession);
    $isServiceProvider = !empty($serviceProviderSession);

    $hasFixedSidebar = $isStudent || $isAdmin || $isLandlord || $isServiceProvider;

    $currentUser = null;
    $currentRole = null;

    if ($isStudent) {
        $currentRole = 'student';
        if ($authUser) {
            $currentUser = \App\Models\Student::where('email', $authUser->email)->first();
        } elseif ($studentSession) {
            $currentUser = \App\Models\Student::find($studentSession);
        }
    }

    if ($isLandlord) {
        $currentRole = 'landlord';
        if ($authUser) {
            $currentUser = \App\Models\Landlord::where('email', $authUser->email)->first();
        } elseif ($landlordSession) {
            $currentUser = \App\Models\Landlord::find($landlordSession);
        }
    }

    if ($isServiceProvider) {
        $currentRole = 'serviceprovider';
        $currentUser = \App\Models\Serviceproviderpartnership::find($serviceProviderSession);
    }

    if ($isAdmin) {
        $currentRole = 'admin';
        $currentUser = \App\Models\Administrator::find($adminSession);
    }

    $status = strtolower(trim(
        (string)($currentUser->status ?? $currentUser->account_status ?? '')
    ));

    $isSuspendedBanner = $currentUser && (
        $status === 'suspended' ||
        ($currentUser->is_suspended ?? false)
    );
?>

<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">

    
    <?php if($isAdmin || $isServiceProvider || $isLandlord || $isStudent): ?>
        
    <?php elseif(Auth::check()): ?>
        <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    
    <?php if(isset($header)): ?>
    <header class="bg-white shadow <?php echo e($hasFixedSidebar ? 'lg:pl-60' : ''); ?>">

        <?php if($isSuspendedBanner): ?>
            <div class="bg-red-600 text-white px-4 py-3 w-full text-center font-semibold">
                Your <?php echo e(ucfirst($currentRole)); ?> account is suspended —
                contact <strong>rentconnect.app@gmail.com</strong>
            </div>
        <?php endif; ?>

        <div class="
            <?php if($isStudent || $isAdmin || $isServiceProvider || $isLandlord): ?>
                w-full
            <?php else: ?>
                max-w-5xl mx-auto
            <?php endif; ?>
            py-6 px-4 sm:px-6 lg:px-8
        ">
            <?php echo e($header); ?>

        </div>
    </header>
    <?php endif; ?>

    
    <main class="<?php echo e($hasFixedSidebar ? 'lg:pl-60' : ''); ?> pb-24 lg:pb-0">
        <?php if($isStudent || $isAdmin || $isServiceProvider || $isLandlord): ?>
            <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
                <?php echo e($slot ?? ''); ?>

            </div>
        <?php else: ?>
            <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <?php echo e($slot ?? ''); ?>

            </div>
        <?php endif; ?>
    </main>

    
    <?php if($isStudent): ?>
        <?php echo $__env->make('partials.student-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php elseif($isLandlord): ?>
        <?php echo $__env->make('partials.landlord-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php elseif($isAdmin): ?>
        <?php echo $__env->make('partials.admin-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php elseif($isServiceProvider): ?>
        <?php echo $__env->make('partials.serviceprovider-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

</div>
</body>
</html>

<?php /**PATH C:\Users\moyak\final-year-project-gracemoore1\resources\views/layouts/app.blade.php ENDPATH**/ ?>