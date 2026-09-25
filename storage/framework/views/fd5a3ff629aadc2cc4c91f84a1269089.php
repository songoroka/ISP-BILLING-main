<?php
if (!function_exists('_fd5a3ff629aadc2cc4c91f84a1269089')):
function _fd5a3ff629aadc2cc4c91f84a1269089($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>
<?php
$__defaults = [
    'package',
    'colorClass' => '',
];
$package ??= $attributes['package']; unset($attributes['package']);
$colorClass ??= $attributes['color-class'] ?? $attributes['colorClass'] ?? $__defaults['colorClass']; unset($attributes['colorClass'], $attributes['color-class']);
unset($__defaults);
?>

<div class="pricing-box <?php echo e($colorClass); ?> <?php echo e($package->is_featured ? 'pricing-box-featured' : ''); ?> w-100">
    <?php
        $icons = [
            'bi-speedometer2',
            'bi-lightning-charge-fill',
            'bi-rocket-takeoff-fill',
            'bi-cpu',
            'bi-router',
            'bi-wifi',
            'bi-globe',
            'bi-activity',
            'bi-ethernet',
            'bi-cloud-arrow-down-fill'
        ];
        $iconIndex = abs(crc32($package->package ?? '')) % count($icons);
        $selectedIcon = $icons[$iconIndex];

        // Speed fallback detection logic
        $speed = $package->speed;
        if (empty($speed)) {
            if (preg_match('/_(\d+)M$/i', $package->package, $matches)) {
                $speed = $matches[1] . ' Mbps';
            } elseif (is_numeric($package->description)) {
                $speed = $package->description . ' Mbps';
            } else {
                $speed = 'Standard';
            }
        }

        // Clean category name for badge
        $cleanCat = 'Standard';
        if ($package->plan_label && strtolower($package->plan_label) !== 'standard') {
            if (str_contains($package->plan_label, '-')) {
                $cleanCat = explode('-', $package->plan_label)[0];
            } else {
                $cleanCat = $package->plan_label;
            }
        }
        $cleanCat = trim($cleanCat);
    ?>

    <div class="pricing-head">
        <h4><?php echo e($package->package); ?></h4>

        <div class="pricing-speed-badge">
            <i class="bi <?php echo e($selectedIcon); ?>"></i>
        </div>
    </div>

    <div class="pricing-lists mb-30">
        <h5><?php echo e($speed); ?></h5>

        <ul class="mt-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $package->features ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <li>
                    <i class="bi bi-check-circle-fill"></i>
                    <?php echo e($feature['value'] ?? $feature); ?>

                </li>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <li><i class="bi bi-check-circle-fill"></i>24 HOURS UNLIMITED</li>
                <li><i class="bi bi-check-circle-fill"></i>Fiber Optics Support</li>
                <li><i class="bi bi-check-circle-fill"></i>24/7 Priority Support</li>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </ul>
    </div>

    <div class="price mb-20">
        <h2><span class="price-amount"><?php echo e(number_format($package->price)); ?>TSh</span> <span>/MONTH</span></h2>
    </div>

    <div class="pricing-btn mt-auto">
        <a href="javascript:void(0)"
            onclick="Livewire.dispatch('open-purchase-modal',{
                packageName:'<?php echo e(addslashes($package->package)); ?>',
                price:<?php echo e($package->price); ?>

            })"
            class="price-btn">
            <span>+</span>Buy Package
        </a>
    </div>
</div><?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /home/skytech/ISP-BILLING-main/resources/views/components/package-card.blade.php ENDPATH**/ ?>