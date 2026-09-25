
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="UTF-8">
    <title><?php echo e($siteData?->hero_title ?? (siteUrlSettings('site_name') ?? config('app.name'))); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo e(siteUrlSettings('site_description') ?? ''); ?>">

    <link rel="shortcut icon" href="<?php echo e(site_image(siteUrlSettings('site_favicon'))); ?>" type="image/x-icon">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/main-site.scss', 'resources/js/main-site.js']); ?>

    <?php $__blaze->ensureRequired('/home/skytech/ISP-BILLING-main/resources/views/components/main-site-theme.blade.php', $__blaze->compiledPath.'/cd433e634aaa429414b6c407d2884bcb.php'); ?>
<?php $__blaze->pushData([]); ?>
<?php _cd433e634aaa429414b6c407d2884bcb($__blaze, [], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
    <script>
        (function() {
            const adminDefaultTheme = "<?php echo e(siteUrlSettings('theme_mode') ?? 'dark'); ?>";
            const userPreferredTheme = localStorage.getItem('site-theme');
            const activeTheme = userPreferredTheme || adminDefaultTheme;
            if (activeTheme === 'light') {
                document.documentElement.classList.add('theme-light');
            } else {
                document.documentElement.classList.remove('theme-light');
            }
        })();
    </script>
    <script>
        <?php
            $tz = config('app.timezone', 'Africa/Dar_es_Salaam');
            $phoneCountry = 'bd';
            if (class_exists('IntlTimeZone')) {
                $region = \IntlTimeZone::getRegion($tz);
                if ($region && strlen($region) === 2) {
                    $phoneCountry = strtolower($region);
                }
            }
        ?>
        window.sitePhoneCountry = '<?php echo e($phoneCountry); ?>';
    </script>
</head>

<body id="top" class="container-fluid m-0 p-0 position-relative overflow-x-hidden">

    
    <header id="navigation" class="navbar sticky-top animated-header navbar-expand-md bg-light">
        <div class="container text-center">
            
            <a class="navbar-brand" href="#top">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(siteUrlSettings('site_logo')): ?>
                    <img class="d-inline-block align-text-top" style="width:190px;height:53px;"
                        src="<?php echo e(site_image(siteUrlSettings('site_logo'))); ?>" alt="logo" />
                <?php else: ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(siteUrlSettings('site_icon')): ?>
                        <img class="d-inline-block align-text-top" src="<?php echo e(site_image(siteUrlSettings('site_icon'))); ?>"
                            alt="" width="40" />
                        <span
                            class="font-sans-serif text-success"><?php echo e(siteUrlSettings('site_name') ?? config('app.name')); ?></span>
                    <?php else: ?>
                        <span
                            class="font-sans-serif text-success"><?php echo e(siteUrlSettings('site_name') ?? config('app.name')); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </a>

            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#banner"><?php echo e(__('Home')); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="#features"><?php echo e(__('Service')); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="#gallery"><?php echo e(__('Gallery')); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="#pricing-table"><?php echo e(__('Price')); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="#team"><?php echo e(__('Team')); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="#blog"><?php echo e(__('Blog')); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonial"><?php echo e(__('Testimonial')); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact-form"><?php echo e(__('Contact')); ?></a></li>
                </ul>
            </div>

            <div class="d-flex align-items-center ms-auto ms-lg-3 me-2 gap-2">
                
                <?php
                    $currentMainLocale = session()->get(
                        'main_site_locale',
                        siteUrlSettings('main_site_locale') ?? 'en',
                    );
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentMainLocale === 'bn'): ?>
                    <a href="<?php echo e(route('welcome.lang', 'en')); ?>"
                        class="btn btn-outline-secondary btn-sm px-2.5 py-1 rounded-3 d-flex align-items-center gap-1 font-sans-serif fw-bold text-decoration-none border-secondary text-secondary"
                        style="font-size: 0.85rem; transition: all 0.3s ease;">
                        <i class="bi bi-globe"></i> EN
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('welcome.lang', 'bn')); ?>"
                        class="btn btn-outline-secondary btn-sm px-2.5 py-1 rounded-3 d-flex align-items-center gap-1 font-sans-serif fw-bold text-decoration-none border-secondary text-secondary"
                        style="font-size: 0.85rem; transition: all 0.3s ease;">
                        <i class="bi bi-globe"></i> বাং
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <button id="theme-toggle"
                    class="btn btn-link rounded-circle p-2 text-light text-decoration-none border-0" type="button"
                    aria-label="Toggle Theme">
                    <i class="bi bi-moon-stars" id="theme-toggle-icon" style="font-size: 1.25rem;"></i>
                </button>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </header>


    <div data-bs-spy="scroll" data-bs-target="#navigation" data-bs-root-margin="0px 0px -40%"
        data-bs-smooth-scroll="true" class="scrollspy-example bg-light rounded-2 wrapper" tabindex="0">

        
        <section id="banner">
            <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel"
                data-bs-interval="7000">

                
                <?php $slides = $siteData?->hero_slides ?? []; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($slides) > 0): ?>
                    <div class="carousel-indicators">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <button type="button" data-bs-target="#carouselExampleCaptions"
                                data-bs-slide-to="<?php echo e($loop->index); ?>" class="<?php echo e($loop->first ? 'active' : ''); ?>"
                                <?php if($loop->first): ?> aria-current="true" <?php endif; ?>
                                aria-label="Slide <?php echo e($loop->iteration); ?>"></button>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div class="carousel-inner">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($slides) > 0): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="carousel-item <?php echo e($loop->first ? 'active' : ''); ?>">
                                <img src="<?php echo e(isset($slide['image']) ? site_image($slide['image']) : ''); ?>"
                                    class="img-fluid" style="width: 100%; height: auto; object-fit: cover;"
                                    alt="<?php echo e($slide['caption'] ?? 'Slide ' . $loop->iteration); ?>">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($slide['caption'])): ?>
                                    <div class="carousel-caption d-none d-md-block">
                                        <h2 class="display-4 fw-bold"><?php echo e($slide['caption']); ?></h2>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php else: ?>
                        
                        <div class="carousel-item active">
                            <img src="<?php echo e(asset('images/slide/img0.jpg')); ?>" class="img-fluid"
                                alt="<?php echo e(__('Slide 1')); ?>">
                        </div>
                        <div class="carousel-item">
                            <img src="<?php echo e(asset('images/slide/img1.jpg')); ?>" class="img-fluid"
                                alt="<?php echo e(__('Slide 2')); ?>">
                        </div>
                        <div class="carousel-item">
                            <img src="<?php echo e(asset('images/slide/img2.jpg')); ?>" class="img-fluid"
                                alt="<?php echo e(__('Slide 3')); ?>">
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>


        
        <section id="features" class="pb-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="title">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($siteData?->about_title): ?>
                                <h5 class="text-success"><?php echo e($siteData->about_title); ?></h5>
                            <?php else: ?>
                                <h5 class="text-success"><?php echo e(__('Welcome to')); ?>

                                    <?php echo e(siteUrlSettings('portal_name') ?? siteUrlSettings('site_name')); ?></h5>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <h2><?php echo e($siteData?->hero_title ?? __('We are always Faster & Reliable')); ?></h2>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($siteData?->about_body): ?>
                                <p><?php echo nl2br(e($siteData->about_body)); ?></p>
                            <?php elseif($siteData?->hero_subtitle): ?>
                                <p><?php echo e($siteData->hero_subtitle); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <h4><?php echo e(__('Our Services are')); ?></h4>
                        </div>
                    </div>
                </div>

                
                <?php $services = $siteData?->services ?? []; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($services) > 0): ?>
                    <div class="row">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="col-md-4 col-xs-6 col-sm-6">
                                <div class="feature-block text-center">
                                    <div class="icon-box">
                                        <i class="<?php echo e($service['icon'] ?? 'bi bi-wifi'); ?>"></i>
                                    </div>
                                    <h4 class="wow fadeInUp" data-wow-delay=".3s"><?php echo e($service['title'] ?? ''); ?></h4>
                                    <p class="wow fadeInUp" data-wow-delay=".5s"><?php echo e($service['description'] ?? ''); ?>

                                    </p>
                                </div>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                <?php else: ?>
                    
                    <div class="row">
                        <div class="col-md-4 col-xs-6 col-sm-6">
                            <div class="feature-block text-center">
                                <div class="icon-box"><i class="bi bi-house-fill"></i></div>
                                <h4 class="wow fadeInUp" data-wow-delay=".3s"><?php echo e(__('Home Internet')); ?></h4>
                                <p class="wow fadeInUp" data-wow-delay=".5s">
                                    <?php echo e(__('High-speed broadband internet for your home. Unlimited data, 24/7 uptime.')); ?>

                                </p>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-6 col-sm-6">
                            <div class="feature-block text-center">
                                <div class="icon-box"><i class="bi bi-building-fill-check"></i></div>
                                <h4 class="wow fadeInUp" data-wow-delay=".3s"><?php echo e(__('Corporate Internet')); ?></h4>
                                <p class="wow fadeInUp" data-wow-delay=".5s">
                                    <?php echo e(__('Dedicated business-grade connectivity with SLA guarantees and priority support.')); ?>

                                </p>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-6 col-sm-6">
                            <div class="feature-block text-center">
                                <div class="icon-box"><i class="bi bi-hdd-network-fill"></i></div>
                                <h4 class="wow fadeInUp" data-wow-delay=".3s"><?php echo e(__('Data Connectivity')); ?></h4>
                                <p class="wow fadeInUp" data-wow-delay=".5s">
                                    <?php echo e(__('Fiber optic point-to-point links for enterprise and campus connectivity needs.')); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </section>

        
        <section id="client-logo" class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="title p-0">
                            <h2 class="text-success"><?php echo e(__('Our Valuable Clients')); ?></h2>
                        </div>
                    </div>
                </div>
                <?php
                    $clients = $siteData?->valuable_clients ?? [];
                    if (count($clients) === 0) {
                        $clients = [
                            ['name' => 'Google'],
                            ['name' => 'Microsoft'],
                            ['name' => 'Amazon'],
                            ['name' => 'Facebook'],
                            ['name' => 'Twitter'],
                            ['name' => 'Apple'],
                            ['name' => 'Intel'],
                            ['name' => 'IBM'],
                            ['name' => 'Oracle'],
                        ];
                    }
                ?>
                <div class="marquee-container">
                    <div class="marquee-content">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="client-item-marquee">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($client['link'])): ?>
                                    <a class="text-decoration-none" href="<?php echo e($client['link']); ?>" target="_blank"
                                        title="<?php echo e($client['name']); ?>">
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <div class="client-name-design">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($client['logo'])): ?>
                                        <img class="client-logo-img" src="<?php echo e(site_image($client['logo'])); ?>"
                                            alt="<?php echo e($client['name']); ?>">
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($client['name'])): ?>
                                        <span><?php echo e($client['name']); ?></span>
                                    <?php else: ?>
                                        <span><?php echo e($client['name']); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($client['link'])): ?>
                                    </a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($clients) < 6): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <div class="client-item-marquee">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($client['link'])): ?>
                                        <a class="text-decoration-none" href="<?php echo e($client['link']); ?>" target="_blank"
                                            title="<?php echo e($client['name']); ?>">
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <div class="client-name-design">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($client['logo'])): ?>
                                            <img class="client-logo-img" src="<?php echo e(site_image($client['logo'])); ?>"
                                                alt="<?php echo e($client['name']); ?>">
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($client['name'])): ?>
                                            <span><?php echo e($client['name']); ?></span>
                                        <?php else: ?>
                                            <span><?php echo e($client['name']); ?></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($client['link'])): ?>
                                        </a>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        
        <section id="gallery" class="bg-success">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="title p-0">
                            <h2><?php echo e(__('LATEST WORKS')); ?></h2>
                        </div>
                        <div x-data="{ filter: 'all' }">
                            <div class="recent-work-mixMenu">
                                <ul>
                                    <li><button type="button" @click="filter='all'"
                                            :class="{ 'active': filter === 'all' }"><?php echo e(__('All')); ?></button>
                                    </li>
                                    <?php $cats = $siteData?->gallery_categories ?? []; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($cats) > 0): ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <?php $catKey = $cat['key'] ?? ($cat['label'] ?? ''); ?>
                                            <li><button type="button" @click="filter='<?php echo e($catKey); ?>'"
                                                    :class="{ 'active': filter === '<?php echo e($catKey); ?>' }"><?php echo e($cat['label'] ?? ($cat['key'] ?? '')); ?></button>
                                            </li>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    <?php else: ?>
                                        <li><button type="button" @click="filter='category-1'"
                                                :class="{ 'active': filter === 'category-1' }"><?php echo e(__('Equipment')); ?></button>
                                        </li>
                                        <li><button type="button" @click="filter='category-2'"
                                                :class="{ 'active': filter === 'category-2' }"><?php echo e(__('Server')); ?></button>
                                        </li>
                                        <li><button type="button" @click="filter='category-3'"
                                                :class="{ 'active': filter === 'category-3' }"><?php echo e(__('Illustration')); ?></button>
                                        </li>
                                        <li><button type="button" @click="filter='category-4'"
                                                :class="{ 'active': filter === 'category-4' }"><?php echo e(__('Media')); ?></button>
                                        </li>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>
                            </div>

                            <div class="recent-work-pic container">
                                <ul id="gallery-images" class="row d-flex justify-content-center">
                                    <?php $galleryItems = $siteData?->gallery_items ?? []; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($galleryItems) > 0): ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $galleryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <?php $itemCat = $item['category'] ?? 'category-1'; ?>
                                            <li :class="filter === 'all' || filter === '<?php echo e($itemCat); ?>' ?
                                                'gallery-show' : 'gallery-hide'"
                                                class="mix <?php echo e($itemCat); ?> col-md-2 col-sm-3 col-4 position-relative"
                                                data-my-order="<?php echo e($index + 1); ?>">
                                                <div class="gallery-item-wrapper position-relative">
                                                    <a class="gallery-items-link d-block" href="#"
                                                        data-bs-toggle="modal" data-bs-target="#galleryModal"
                                                        data-bs-image="<?php echo e(site_image($item['image'])); ?>"
                                                        data-bs-caption="<?php echo e($item['caption'] ?? ''); ?>">
                                                        <img class="img-thumbnail"
                                                            src="<?php echo e(site_image($item['image'])); ?>"
                                                            alt="<?php echo e($item['caption'] ?? ''); ?>">
                                                        <div class="overlay">
                                                            <h3><?php echo e($item['caption'] ?? __('View')); ?></h3>
                                                            <i class="bi bi-diagram-3-fill"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    <?php else: ?>
                                        
                                        <li :class="filter === 'all' || filter === 'category-1' ? 'gallery-show' :
                                            'gallery-hide'"
                                            class="mix category-1 col-md-2 col-sm-3 col-4 position-relative">
                                            <div class="gallery-item-wrapper position-relative">
                                                <a class="gallery-items-link d-block" href="#"
                                                    data-bs-toggle="modal" data-bs-target="#galleryModal"
                                                    data-bs-image="<?php echo e(asset('images/gallery/spliceing.jpg')); ?>"
                                                    data-bs-caption="<?php echo e(__('Splicing')); ?>">
                                                    <img class="img-thumbnail" src="images/gallery/spliceing.jpg"
                                                        alt="">
                                                    <div class="overlay">
                                                        <h3><?php echo e(__('Splicing')); ?></h3><i
                                                            class="bi bi-diagram-3-fill"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </li>
                                        <li :class="filter === 'all' || filter === 'category-1' ? 'gallery-show' :
                                            'gallery-hide'"
                                            class="mix category-1 col-md-2 col-sm-3 col-4 position-relative">
                                            <div class="gallery-item-wrapper position-relative">
                                                <a class="gallery-items-link d-block" href="#"
                                                    data-bs-toggle="modal" data-bs-target="#galleryModal"
                                                    data-bs-image="<?php echo e(asset('images/gallery/Clever.png')); ?>"
                                                    data-bs-caption="<?php echo e(__('Clever')); ?>">
                                                    <img class="img-thumbnail" src="images/gallery/Clever.png"
                                                        alt="">
                                                    <div class="overlay">
                                                        <h3><?php echo e(__('Clever')); ?></h3><i
                                                            class="bi bi-diagram-3-fill"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </li>
                                        <li :class="filter === 'all' || filter === 'category-1' ? 'gallery-show' :
                                            'gallery-hide'"
                                            class="mix category-1 col-md-2 col-sm-3 col-4 position-relative">
                                            <div class="gallery-item-wrapper position-relative">
                                                <a class="gallery-items-link d-block" href="#"
                                                    data-bs-toggle="modal" data-bs-target="#galleryModal"
                                                    data-bs-image="<?php echo e(asset('images/gallery/crimping.jpg')); ?>"
                                                    data-bs-caption="<?php echo e(__('Crimping')); ?>">
                                                    <img class="img-thumbnail" src="images/gallery/crimping.jpg"
                                                        alt="">
                                                    <div class="overlay">
                                                        <h3><?php echo e(__('Crimping')); ?></h3><i
                                                            class="bi bi-diagram-3-fill"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </li>
                                        <li :class="filter === 'all' || filter === 'category-2' ? 'gallery-show' :
                                            'gallery-hide'"
                                            class="mix category-2 col-md-2 col-sm-3 col-4 position-relative">
                                            <div class="gallery-item-wrapper position-relative">
                                                <a class="gallery-items-link d-block" href="#"
                                                    data-bs-toggle="modal" data-bs-target="#galleryModal"
                                                    data-bs-image="<?php echo e(asset('images/gallery/server.jpg')); ?>"
                                                    data-bs-caption="<?php echo e(__('Server')); ?>">
                                                    <img class="img-thumbnail" src="images/gallery/server.jpg"
                                                        alt="">
                                                    <div class="overlay">
                                                        <h3><?php echo e(__('Server')); ?></h3><i class="bi bi-server"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </li>
                                        <li :class="filter === 'all' || filter === 'category-2' ? 'gallery-show' :
                                            'gallery-hide'"
                                            class="mix category-2 col-md-2 col-sm-3 col-4 position-relative">
                                            <div class="gallery-item-wrapper position-relative">
                                                <a class="gallery-items-link d-block" href="#"
                                                    data-bs-toggle="modal" data-bs-target="#galleryModal"
                                                    data-bs-image="<?php echo e(asset('images/gallery/rack.jpg')); ?>"
                                                    data-bs-caption="<?php echo e(__('Rack')); ?>">
                                                    <img class="img-thumbnail" src="images/gallery/rack.jpg"
                                                        alt="">
                                                    <div class="overlay">
                                                        <h3><?php echo e(__('Rack')); ?></h3><i class="bi bi-server"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </li>
                                        <li :class="filter === 'all' || filter === 'category-3' ? 'gallery-show' :
                                            'gallery-hide'"
                                            class="mix category-3 col-md-2 col-sm-3 col-4 position-relative">
                                            <div class="gallery-item-wrapper position-relative">
                                                <a class="gallery-items-link d-block" href="#"
                                                    data-bs-toggle="modal" data-bs-target="#galleryModal"
                                                    data-bs-image="<?php echo e(asset('images/gallery/Patchcord.jpeg')); ?>"
                                                    data-bs-caption="<?php echo e(__('Patchcord')); ?>">
                                                    <img class="img-thumbnail" src="images/gallery/Patchcord.jpeg"
                                                        alt="">
                                                    <div class="overlay">
                                                        <h3><?php echo e(__('Patchcord')); ?></h3><i class="bi bi-ethernet"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </li>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>
                            </div>

                            <!-- Bootstrap Gallery Modal -->
                            <div class="modal fade" id="galleryModal" tabindex="-1"
                                aria-labelledby="galleryModalLabel" aria-hidden="true" style="z-index: 2050;">
                                <div class="modal-dialog modal-dialog-centered"
                                    style="max-width: fit-content; margin: 1.75rem auto;">
                                    <div class="modal-content border-0 bg-transparent shadow-none position-relative mx-auto"
                                        style="width: fit-content;">
                                        <!-- Float Close Button -->
                                        <button type="button"
                                            class="btn border-0 text-white position-absolute top-0 end-0 m-2 shadow-none"
                                            data-bs-dismiss="modal" aria-label="Close"
                                            style="font-size: 2rem; z-index: 1055; text-shadow: 0 2px 10px rgba(0,0,0,0.8);">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                        <div class="modal-body text-center p-0">
                                            <img id="galleryModalImage" src=""
                                                class="img-fluid rounded-4 shadow-lg"
                                                style="max-height: 80vh; max-width: 90vw; object-fit: contain; border: 4px solid rgba(255,255,255,0.15);">
                                            <!-- Caption -->
                                            <h5 class="text-white mt-3 fw-bold font-sans-serif" id="galleryModalLabel"
                                                style="text-shadow: 0 2px 8px rgba(0,0,0,0.8); font-size: 1.25rem;">
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        
        <section id="pricing-table">
            <div class="container">
                <div class="row">
                    <div class="title">
                        <h2 class="p-0"><?php echo e($siteData?->packages_section_title ?? __('INTERNET PACKAGE PLAN')); ?>

                        </h2>
                        <h5 class="text-success mb-3">
                            <?php echo e($siteData?->packages_section_subtitle ?? __('We offer the best Internet Package Plan for You')); ?>

                        </h5>
                    </div>
                </div>

                <?php
                    $pkgColors = ['', 'pricing-box-2', 'pricing-box-3', ''];
                ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($packages->isNotEmpty()): ?>
                    <div class="px-md-5 position-relative">
                        <div class="swiper pricing-swiper">
                            <div class="swiper-wrapper">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="swiper-slide h-auto d-flex">
                                        <?php $__blaze->ensureRequired('/home/skytech/ISP-BILLING-main/resources/views/components/package-card.blade.php', $__blaze->compiledPath.'/fd5a3ff629aadc2cc4c91f84a1269089.php'); ?>
<?php $__blaze->pushData(['package' => $package,'colorClass' => $pkgColors[$index % 4]]); ?>
<?php _fd5a3ff629aadc2cc4c91f84a1269089($__blaze, ['package' => $package,'colorClass' => $pkgColors[$index % 4]], [], ['package', 'colorClass'], ['colorClass' => 'color-class'], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>

                            <!-- Pagination -->
                            <div class="swiper-pagination mt-4"></div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="swiper-button-prev pricing-prev-btn"></div>
                        <div class="swiper-button-next pricing-next-btn"></div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <p class="text-muted">
                            <?php echo e(__('No packages available.')); ?>

                        </p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="text-center">
                    <a href="<?php echo e(route('all-packages')); ?>" class="all-pack-btn btn btn-sm rounded-pill px-5">
                        <?php echo e(__('View All Packages')); ?>

                    </a>
                </div>
            </div>
        </section>

        
        <section id="team" class="bg-success">
            <div class="container">
                <div class="row">
                    <div class="title">
                        <h2><?php echo e($siteData?->team_title ?? __('CREATIVE TEAM')); ?></h2>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($siteData?->team_subtitle): ?>
                            <p><?php echo nl2br(e($siteData->team_subtitle)); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="col-md-12">
                        <?php
                            $teamMembers = $siteData?->team_members ?? [];
                            if (count($teamMembers) === 0) {
                                $teamMembers = [
                                    [
                                        'name' => __('TEAM MEMBER 1'),
                                        'role' => __('Staff'),
                                        'bio' => __('Dedicated team member committed to providing excellent service.'),
                                    ],
                                    [
                                        'name' => __('TEAM MEMBER 2'),
                                        'role' => __('Staff'),
                                        'bio' => __('Dedicated team member committed to providing excellent service.'),
                                    ],
                                    [
                                        'name' => __('TEAM MEMBER 3'),
                                        'role' => __('Staff'),
                                        'bio' => __('Dedicated team member committed to providing excellent service.'),
                                    ],
                                    [
                                        'name' => __('TEAM MEMBER 4'),
                                        'role' => __('Staff'),
                                        'bio' => __('Dedicated team member committed to providing excellent service.'),
                                    ],
                                ];
                            }
                        ?>

                        <div id="teamCarousel" class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $teamMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="swiper-slide p-1">
                                        <div class="block wow fadeInLeft w-100 h-100 d-flex flex-column"
                                            data-wow-delay=".3s">
                                            <img src="<?php echo e(isset($member['image']) && $member['image'] ? site_image($member['image']) : asset('images/team-demo.png')); ?>"
                                                alt="<?php echo e($member['name'] ?? ''); ?>">
                                            <div class="team-overlay">
                                                <h3><?php echo e(strtoupper($member['name'] ?? '')); ?>

                                                    <span><?php echo e($member['role'] ?? ''); ?></span>
                                                </h3>
                                                <span class="icon"><i class="bi bi-chat-quote"></i></span>
                                                <p><?php echo e($member['bio'] ?? ''); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                            
                            <div class="swiper-pagination"></div>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($teamMembers) > 1): ?>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($reviews) > 0): ?>
            <section id="reviews" class="pb-1 pt-5" style="background: #f8f9fc;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title text-center mb-2" style="text-align: center; margin-bottom: 3rem;">
                                <h2 class="text-success mb-0" style="font-weight: bold;">
                                    <?php echo e(__('What Our Clients Say')); ?></h2>
                                <p>
                                    <?php echo e(__('Feedback and reviews from our active internet subscribers')); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="px-md-5 position-relative">
                        <div class="swiper reviews-swiper pt-2 pb-3">
                            <div class="swiper-wrapper">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="swiper-slide h-auto d-flex">
                                        <div class="card w-100 border-0 shadow-sm p-4"
                                            style="border-radius: 20px; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.05); background: #ffffff; height: 100%;">
                                            <div class="d-flex align-items-center mb-3"
                                                style="display: flex; align-items: center; margin-bottom: 1rem;">
                                                <div class="avatar-circle d-flex align-items-center justify-content-center fw-bold text-success me-3"
                                                    style="width: 48px; height: 48px; min-width: 48px; border-radius: 50%; background: #e8f5e9; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 1rem; font-size: 1.2rem;">
                                                    <?php echo e(strtoupper(substr($review->pppUser?->customer?->customer_name ?? ($review->pppUser?->username ?? 'C'), 0, 1))); ?>

                                                </div>
                                                <div>
                                                    <h5 class="mb-0 fw-bold text-dark"
                                                        style="font-size: 0.95rem; margin: 0; font-weight: 700; color: #1a1f36;">
                                                        <?php echo e($review->pppUser?->customer?->customer_name ?? __('Valued Customer')); ?>

                                                    </h5>
                                                    <span
                                                        style="font-size: 0.75rem;"><?php echo e(__('Active Member')); ?></span>
                                                </div>
                                            </div>

                                            <div class="mb-2"
                                                style="color: #ffc107; display: flex; gap: 2px; margin-bottom: 0.5rem;">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                    <i class="bi <?php echo e($review->rating >= $i ? 'bi-star-fill' : 'bi-star'); ?>"
                                                        style="font-size: 0.85rem;"></i>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                            </div>

                                            <p class="card-text text-secondary"
                                                style="font-size: 0.85rem; font-style: italic; color: #4f566b; line-height: 1.5; margin: 0;">
                                                "<?php echo e($review->comment); ?>"
                                            </p>
                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>

                            <!-- Pagination -->
                            <div class="swiper-pagination mt-4"></div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="swiper-button-prev reviews-prev-btn"></div>
                        <div class="swiper-button-next reviews-next-btn"></div>
                    </div>
                </div>
            </section>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>



        
        <section id="blog">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="title">
                            <h2 class="text-success"><?php echo e($siteData?->blog_title ?? __('Blog')); ?></h2>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($siteData?->blog_subtitle): ?>
                                <p><?php echo nl2br(e($siteData->blog_subtitle)); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <?php
                            $blogPosts = $siteData?->blog_posts ?? [];
                            if (count($blogPosts) === 0) {
                                $blogPosts = [
                                    [
                                        'title' => __('Latest News & Updates 1'),
                                        'author' => __('Admin'),
                                        'excerpt' => __(
                                            'Stay updated with the latest news, offers, and updates from our network team.',
                                        ),
                                    ],
                                    [
                                        'title' => __('Latest News & Updates 2'),
                                        'author' => __('Admin'),
                                        'excerpt' => __(
                                            'Stay updated with the latest news, offers, and updates from our network team.',
                                        ),
                                    ],
                                    [
                                        'title' => __('Latest News & Updates 3'),
                                        'author' => __('Admin'),
                                        'excerpt' => __(
                                            'Stay updated with the latest news, offers, and updates from our network team.',
                                        ),
                                    ],
                                    [
                                        'title' => __('Latest News & Updates 4'),
                                        'author' => __('Admin'),
                                        'excerpt' => __(
                                            'Stay updated with the latest news, offers, and updates from our network team.',
                                        ),
                                    ],
                                ];
                            }
                            $blogChunks = array_chunk($blogPosts, 3);
                        ?>

                        <div class="px-md-5 position-relative">
                            <div class="swiper blog-swiper">
                                <div class="swiper-wrapper">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $blogPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <div class="swiper-slide h-auto d-flex">
                                            <div class="block w-100 d-flex flex-column justify-content-between">
                                                <div>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($post['image'])): ?>
                                                        <img src="<?php echo e(site_image($post['image'])); ?>"
                                                            alt="<?php echo e($post['title'] ?? ''); ?>" class="img-thumbnail">
                                                    <?php else: ?>
                                                        <img src="<?php echo e(site_image(siteUrlSettings('site_logo'))); ?>"
                                                            alt="<?php echo e($post['title'] ?? ''); ?>" class="img-thumbnail">
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <div class="content">
                                                        <h4>
                                                            <a
                                                                href="<?php echo e($post['link'] ?? '#'); ?>"><?php echo e($post['title'] ?? ''); ?></a>
                                                        </h4>
                                                        <small style="color: var(--primary-color-light)"><?php echo e(__('By')); ?>

                                                            <?php echo e($post['author'] ?? __('Admin')); ?>

                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($post['date'])): ?>
                                                                /
                                                                <?php echo e(\Carbon\Carbon::parse($post['date'])->format('M d, Y')); ?>

                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </small>
                                                        <p style="color: var(--dark-color-light) !important;"><?php echo e($post['excerpt'] ?? ''); ?></p>
                                                    </div>
                                                </div>
                                                <div class="content pt-0">
                                                    <a href="<?php echo e($post['link'] ?? '#'); ?>"
                                                        class="btn btn-read text-success"><?php echo e(__('Read More')); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>

                                <!-- Pagination -->
                                <div class="swiper-pagination mt-4"></div>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="swiper-button-prev blog-prev-btn"></div>
                            <div class="swiper-button-next blog-next-btn"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        
        <section id="testimonial">
            <div class="container">
                <div class="row">
                    <div class="title">
                        <h2 class="text-white"><?php echo e($siteData?->testimonial_title ?? __('Testimonial')); ?></h2>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($siteData?->testimonial_subtitle): ?>
                            <p><?php echo nl2br(e($siteData->testimonial_subtitle)); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <?php $testimonials = $siteData?->testimonials ?? []; ?>
                    <div class="px-md-5 position-relative">
                        <div class="swiper testimonial-swiper">
                            <div class="swiper-wrapper">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($testimonials) > 0): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <div class="swiper-slide h-auto d-flex">
                                            <div class="media w-100 wow fadeInLeft" data-wow-delay=".3s">
                                                <div class="media-left">
                                                    <a href="#">
                                                        <img src="<?php echo e(!empty($testimonial['image']) ? site_image($testimonial['image']) : asset('images/team-demo.png')); ?>"
                                                            alt="<?php echo e($testimonial['name'] ?? ''); ?>">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <a href="#">
                                                        <h4 class="media-heading"><?php echo e($testimonial['name'] ?? ''); ?>

                                                        </h4>
                                                    </a>
                                                    <p><?php echo e($testimonial['message'] ?? ''); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <?php else: ?>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Satisfied Customer', 'Happy Client', 'Regular User', 'Business Owner']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <div class="swiper-slide h-auto d-flex">
                                            <div class="media w-100 wow fadeInLeft" data-wow-delay=".3s">
                                                <div class="media-left">
                                                    <a href="#"><img src="<?php echo e(asset('images/team-demo.png')); ?>"
                                                            alt=""></a>
                                                </div>
                                                <div class="media-body">
                                                    <a href="#">
                                                        <h4 class="media-heading"><?php echo e(__($name)); ?></h4>
                                                    </a>
                                                    <p><?php echo e(__('Excellent internet service with fast speeds and reliable uptime. Customer support is always responsive and helpful. Highly recommended!')); ?>

                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <!-- Pagination -->
                            <div class="swiper-pagination mt-4"></div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="swiper-button-prev testimonial-prev-btn"></div>
                        <div class="swiper-button-next testimonial-next-btn"></div>
                    </div>
                </div>
            </div>
        </section>


        
        <section id="contact-form">
            <div class="container">
                <div class="row">
                    <div class="title">
                        <h2 class="text-success"><?php echo e($siteData?->contact_title ?? __('CONTACT US')); ?></h2>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($siteData?->contact_subtitle): ?>
                            <p><?php echo nl2br(e($siteData->contact_subtitle)); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="map">
                            <div id="googleMap">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($siteData?->google_map_embed): ?>
                                    <iframe src="<?php echo e($siteData->google_map_embed); ?>" width="600" height="450"
                                        style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                <?php elseif(siteUrlSettings('site_map')): ?>
                                    <iframe src="<?php echo e(siteUrlSettings('site_map')); ?>" width="600" height="450"
                                        style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                <?php else: ?>
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d97559.35009863286!2d90.89949961876307!3d24.672873925245927!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3756e83b9c19e2e5%3A0xa7695289d8c1a5c1!2sMadan%20Upazila!5e0!3m2!1sen!2sbd!4v1770660584969!5m2!1sen!2sbd"
                                        width="600" height="450" style="border:0;" allowfullscreen=""
                                        loading="lazy"></iframe>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12 mt-4 mt-md-0">
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('CommentSubmit', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-104803721-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
                    </div>
                </div>
            </div>
        </section>


        
        <footer>
            <div class="container">
                <div class="row">
                    <!-- Column 1: Company Info & Socials -->
                    <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                        <div>
                            <a href="#top">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(siteUrlSettings('site_logo')): ?>
                                    <img class="d-inline-block align-text-top mb-3" style="max-width: 190px;"
                                        src="<?php echo e(site_image(siteUrlSettings('site_logo'))); ?>" alt="logo" />
                                <?php else: ?>
                                    <h3 class="text-white fw-bold">
                                        <?php echo e(siteUrlSettings('site_name') ?? config('app.name')); ?></h3>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </a>
                            <p class="mb-1"><i
                                    class="bi bi-geo-alt me-2"></i><?php echo e(siteUrlSettings('site_address') ?? __('Our Head Office')); ?>

                            </p>
                            <p class="mb-1"><i
                                    class="bi bi-telephone me-2"></i><?php echo e(siteUrlSettings('help_desk_phone') ?? siteUrlSettings('site_phone') ?? '+255622221464/+255754448446'); ?>

                            </p>
                            <p class="mb-3"><i
                                    class="bi bi-envelope me-2"></i><?php echo e(siteUrlSettings('site_email') ?? 'support@example.com'); ?>

                            </p>



                            
                            <?php
                                $fb = siteUrlSettings('site_facebook');
                                $tw = siteUrlSettings('site_twitter');
                                $ig = siteUrlSettings('site_instagram');
                                $yt = siteUrlSettings('site_youtube');
                                $wa = siteUrlSettings('site_whatsapp');
                            ?>
                            <div class="mt-2 d-flex gap-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($fb): ?>
                                    <a href="<?php echo e($fb); ?>" target="_blank" class="social-link"><i
                                            class="bi bi-facebook"></i></a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tw): ?>
                                    <a href="<?php echo e($tw); ?>" target="_blank" class="social-link"><i
                                            class="bi bi-twitter-x"></i></a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ig): ?>
                                    <a href="<?php echo e($ig); ?>" target="_blank" class="social-link"><i
                                            class="bi bi-instagram"></i></a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($yt): ?>
                                    <a href="<?php echo e($yt); ?>" target="_blank" class="social-link"><i
                                            class="bi bi-youtube"></i></a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($wa): ?>
                                    <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $wa)); ?>" target="_blank"
                                        class="social-link"><i class="bi bi-whatsapp"></i></a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Quick Links -->
                    <div class="col-lg-3 col-md-6 col-6 mb-4 mb-lg-0">
                        <h5 class="text-light fw-bold mb-3" style="font-size: 1.1rem;"><?php echo e(__('Quick Links')); ?></h5>
                        <ul class="footer-links-list">
                            <li><a href="https://portal.<?php echo e(request()->getHost()); ?>"
                                    target="_blank"><?php echo e(__('Client Portal')); ?></a></li>
                            <li><a href="<?php echo e(route('policy.show')); ?>"><?php echo e(__('Privacy Policy')); ?></a></li>
                            <li><a href="<?php echo e(route('terms.show')); ?>"><?php echo e(__('Terms & Conditions')); ?></a></li>
                            <li><a href="<?php echo e($siteData->btcl_tariff_link ?? '#'); ?>"
                                    target="_blank"><?php echo e(__('BTCL Tariff PDF')); ?></a></li>
                        </ul>
                    </div>

                    <!-- Column 3: Useful Links -->
                    <div class="col-lg-3 col-md-6 col-6 mb-4 mb-lg-0">
                        <h5 class="text-light fw-bold mb-3" style="font-size: 1.1rem;"><?php echo e(__('Useful Links')); ?></h5>
                        <ul class="footer-links-list">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($siteData->important_links)): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $siteData->important_links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($link['label']) && !empty($link['url'])): ?>
                                        <li><a href="<?php echo e($link['url']); ?>" target="_blank"><?php echo e($link['label']); ?></a>
                                        </li>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php else: ?>
                                <li class="text-muted small"><?php echo e(__('No links configured.')); ?></li>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </ul>
                    </div>

                    <!-- Column 4: Visitor Counters -->
                    <div class="col-lg-2 col-md-6 col-12 text-lg-end text-start">
                        <div class="row g-2">
                            <div class="col-lg-12 col-6 mb-3 mb-lg-3">
                                <h6 class="mb-1 text-uppercase visitor-counter-title total-title"
                                    style="font-size: 0.65rem; letter-spacing: 0.5px;"><?php echo e(__('Total Page Views')); ?>

                                </h6>
                                <div class="visitor-counter-badge justify-content-lg-end justify-content-start">
                                    <?php
                                        $formattedTotal = sprintf('%06d', $totalVisits ?? 0);
                                        $totalDigits = str_split($formattedTotal);
                                    ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $totalDigits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $digit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <span class="visitor-digit total-digit"><?php echo e($digit); ?></span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>
                            </div>
                            <div class="col-lg-12 col-6">
                                <h6 class="mb-1 text-uppercase visitor-counter-title unique-title"
                                    style="font-size: 0.65rem; letter-spacing: 0.5px;"><?php echo e(__('Unique Visitors')); ?>

                                </h6>
                                <div class="visitor-counter-badge justify-content-lg-end justify-content-start">
                                    <?php
                                        $formattedUnique = sprintf('%06d', $uniqueVisitors ?? 0);
                                        $uniqueDigits = str_split($formattedUnique);
                                    ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $uniqueDigits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $digit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <span class="visitor-digit unique-digit"><?php echo e($digit); ?></span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mt-4 mb-3 border-secondary opacity-25">
                <div class="row align-items-center">
                    <div class="col-md-6 text-md-start text-center mb-2 mb-md-0">
                        <p class="text-muted small mb-0">
                            © <?php echo e(siteUrlSettings('site_name') ?? config('app.name')); ?> <?php echo e(date('Y')); ?>. All Rights Reserved
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end text-center">
                        <p class="text-muted small mb-0">
                            Designed & Develoved by : <a href="https://infranet.co.tz" target="_blank" class="text-muted text-decoration-none fw-semibold">SKYTECH INFRANET</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>

    </div>

    
    <button type="button" class="btn btn-floating" id="btn-back-to-top">
        <i class="bi bi-arrow-up-circle"></i>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('theme-toggle');
            const themeToggleIcon = document.getElementById('theme-toggle-icon');

            function updateToggleIcon(isLight) {
                if (isLight) {
                    themeToggleIcon.className = 'bi bi-sun';
                    themeToggle.classList.remove('text-light');
                    themeToggle.classList.add('text-dark');
                } else {
                    themeToggleIcon.className = 'bi bi-moon-stars';
                    themeToggle.classList.remove('text-dark');
                    themeToggle.classList.add('text-light');
                }
            }

            // Initial setup
            const isLight = document.documentElement.classList.contains('theme-light');
            updateToggleIcon(isLight);

            themeToggle.addEventListener('click', function() {
                const currentlyLight = document.documentElement.classList.toggle('theme-light');
                localStorage.setItem('site-theme', currentlyLight ? 'light' : 'dark');
                updateToggleIcon(currentlyLight);
            });
        });
    </script>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('package-purchase-form', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-104803721-1', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
</body>

</html>
<?php /**PATH /home/skytech/ISP-BILLING-main/resources/views/main-site.blade.php ENDPATH**/ ?>