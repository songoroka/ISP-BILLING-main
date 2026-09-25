<?php
if (!function_exists('_cd433e634aaa429414b6c407d2884bcb')):
function _cd433e634aaa429414b6c407d2884bcb($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>
<?php
    // ─────────────────────────────────────────────────────────────────────────────
    // MAIN SITE THEME ENGINE
    // Controls: main landing page colors, font, dark-mode, section height
    // Does NOT affect customer portal (portal.* is controlled by portal_theme_preset)
    // ─────────────────────────────────────────────────────────────────────────────

    $theme_name = siteUrlSettings('theme_name') ?? 'default';

    // Preset color map — each preset has a ready-made primary + secondary
    $presets = [
        'emerald_isp'     => ['primary' => '#06ad73', 'secondary' => '#ff6b35'],
        'ocean_blue'      => ['primary' => '#0284c7', 'secondary' => '#38bdf8'],
        'midnight_purple' => ['primary' => '#4f46e5', 'secondary' => '#818cf8'],
        'cyber_neon'      => ['primary' => '#00ffcc', 'secondary' => '#ff007f'],
        'rose_elegant'    => ['primary' => '#f43f5e', 'secondary' => '#fda4af'],
        'islamic_green'   => ['primary' => '#065f46', 'secondary' => '#10b981'],
        'golden_sunset'   => ['primary' => '#f59e0b', 'secondary' => '#ef4444'],
    ];

    // Resolve colors
    if ($theme_name === 'default' || !$theme_name) {
        $primary   = null;
        $secondary = null;
    } elseif ($theme_name === 'custom') {
        $primary   = siteUrlSettings('theme_primary_color')  ?: null;
        $secondary = siteUrlSettings('theme_accent_color')   ?: null;
    } elseif (isset($presets[$theme_name])) {
        $primary   = $presets[$theme_name]['primary'];
        $secondary = $presets[$theme_name]['secondary'];
    } else {
        $primary   = null;
        $secondary = null;
    }

    // Other settings
    $fontFamily    = siteUrlSettings('theme_font_family')    ?: null;
    $darkMode      = siteUrlSettings('theme_mode')           ?: null; // 'dark' | 'light' | ''
    $sectionHeight = siteUrlSettings('theme_section_height') ?: 'auto';

    // Helper: hex → "r, g, b"
    $getRgb = function ($hex) {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }
        return hexdec(substr($hex, 0, 2)).', '.hexdec(substr($hex, 2, 2)).', '.hexdec(substr($hex, 4, 2));
    };

    $primaryRgb   = $primary   ? $getRgb($primary)   : null;
    $secondaryRgb = $secondary ? $getRgb($secondary) : null;

    // Only inject if at least one setting is active
    $hasCustomization = $primary || $secondary || $fontFamily
                        || ($darkMode && in_array($darkMode, ['dark', 'light']))
                        || $sectionHeight !== 'auto';
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasCustomization): ?>
<style id="main-site-dynamic-styles">
    :root {
        <?php if($primary): ?>
        --primary-color:       <?php echo e($primary); ?>;
        --primary-rgb:         <?php echo e($primaryRgb); ?>;
        --primary-color-light: rgba(<?php echo e($primaryRgb); ?>, 0.35);
        --primary-color-text:  <?php echo e($primary); ?>;
        --primary-gradient:    linear-gradient(135deg, <?php echo e($primary); ?> 0%, rgba(<?php echo e($primaryRgb); ?>, 0.65) 100%);
        --glass-glow-border:   rgba(<?php echo e($primaryRgb); ?>, 0.18);
        <?php endif; ?>

        <?php if($secondary): ?>
        --secondary-color:       <?php echo e($secondary); ?>;
        --secondary-rgb:         <?php echo e($secondaryRgb); ?>;
        --secondary-color-light: rgba(<?php echo e($secondaryRgb); ?>, 0.35);
        --secondary-color-text:  <?php echo e($secondary); ?>;
        --secondary-gradient:    linear-gradient(135deg, <?php echo e($secondary); ?> 0%, rgba(<?php echo e($secondaryRgb); ?>, 0.65) 100%);
        --accent-color:          <?php echo e($secondary); ?>;
        --accent-rgb:            <?php echo e($secondaryRgb); ?>;
        --accent-gradient:       linear-gradient(135deg, <?php echo e($secondary); ?> 0%, <?php echo e($primary ?? 'var(--primary-color)'); ?> 100%);
        <?php endif; ?>

        <?php if($fontFamily): ?>
        --font-heading: "<?php echo e($fontFamily); ?>", system-ui, -apple-system, sans-serif;
        --font-body:    "<?php echo e($fontFamily); ?>", system-ui, -apple-system, sans-serif;
        <?php endif; ?>

        <?php if($sectionHeight !== 'auto'): ?>
        --section-min-height: <?php echo e($sectionHeight); ?>;
        <?php endif; ?>
    }
</style>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($darkMode && in_array($darkMode, ['dark', 'light'])): ?>
<script>
    (function () {
        var m = '<?php echo e($darkMode); ?>';
        document.documentElement.setAttribute('data-bs-theme', m);
        document.documentElement.setAttribute('data-theme', m);
        if (m === 'dark') {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('theme-light');
        } else {
            document.documentElement.classList.remove('dark');
            document.documentElement.classList.add('theme-light');
        }
    })();
</script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /home/skytech/ISP-BILLING-main/resources/views/components/main-site-theme.blade.php ENDPATH**/ ?>