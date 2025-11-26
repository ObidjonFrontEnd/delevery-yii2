<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;



if (Yii::$app->session->hasFlash('success')) {
    $message = Yii::$app->session->getFlash('success');
    $this->registerJs("
        notification.success(" . json_encode($message) . ", " . json_encode(Yii::t('app', 'Success!')) . ");
    ", View::POS_READY);
}

if (Yii::$app->session->hasFlash('error')) {
    $message = Yii::$app->session->getFlash('error');
    $this->registerJs("
        notification.error(" . json_encode($message) . ", " . json_encode(Yii::t('app', 'Error!')) . ");
    ", View::POS_READY);
}

if (Yii::$app->session->hasFlash('warning')) {
    $message = Yii::$app->session->getFlash('warning');
    $this->registerJs("
        notification.warning(" . json_encode($message) . ", " . json_encode(Yii::t('app', 'Warning!')) . ");
    ", View::POS_READY);
}

if (Yii::$app->session->hasFlash('info')) {
    $message = Yii::$app->session->getFlash('info');
    $this->registerJs("
        notification.info(" . json_encode($message) . ", " . json_encode(Yii::t('app', 'Information')) . ");
    ", View::POS_READY);
}


AppAsset::register($this);
$logoUrl = Yii::getAlias('@web') . '/image/default.jpg';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= \yii\helpers\Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body id="kt_app_body" data-kt-app-header-fixed-mobile="true" data-kt-app-toolbar-enabled="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" class="app-default">
<?php $this->beginBody() ?>



<div class="d-flex flex-column flex-root app-root" id="kt_app_root">

    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">

        <div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: false, lg: true}" data-kt-sticky-name="app-header-sticky" data-kt-sticky-offset="{default: false, lg: '300px'}">

            <div class="app-container container-fluid d-flex flex-stack" id="kt_app_header_container">

                <div class="d-flex align-items-center d-block d-lg-none ms-n3" title="Show sidebar menu">
                    <div class="btn btn-icon btn-active-color-primary w-35px h-35px me-2" id="kt_app_sidebar_mobile_toggle">
                        <i class="ki-outline ki-abstract-14 fs-2"></i>
                    </div>

                    <a href="<?=(url::to(['site/index']))?>">
                        <img alt="Logo" src="<?=Yii::getAlias('@web')?>/template/assets/media/logos/default-small.svg" class="h-30px theme-light-show" />
                        <img alt="Logo" src="<?=Yii::getAlias('@web')?>/template/assets/media/logos/default-small-dark.svg" class="h-30px theme-dark-show" />
                    </a>

                </div>

                <div class="d-flex flex-stack flex-lg-row-fluid" id="kt_app_header_wrapper">

                    <div class="page-title gap-4 me-3 mb-5 mb-lg-0" data-kt-swapper="1" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}">

                        <?= Breadcrumbs::widget([
                                'links' => $this->params['breadcrumbs'] ?? [],
                                'options' => [
                                        'class' => 'breadcrumb text-muted fs-6 fw-semibold',
                                ],
                                'itemTemplate' => '<li class="breadcrumb-item px-2">{link}</li>',
                        ]) ?>

                        <h1 class="text-gray-900 mt-3 fw-bolder m-0 px-2"><?=($this->title)?></h1>

                    </div>



                </div>

            </div>

        </div>


            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">

                <!--begin::Sidebar-->
                <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
                    <!--begin::Header-->
                    <div class=" logo app-sidebar-header  d-none d-lg-flex px-6 pt-8 pb-4" id="kt_app_sidebar_header">
                        <!--begin::Toggle-->
                        <?php
                            echo Html::a(
                            '<span class="d-flex flex-center flex-shrink-0 w-40px me-3">
                                        <img alt="Logo" src="' . $logoUrl . '" data-kt-element="logo" class="h-30px" />
                                    </span>
                                    <span class="d-flex flex-column align-items-start flex-grow-1">
                                        <span class="fs-5 fw-bold text-white text-uppercase" data-kt-element="title">Oshxona.uz</span>
                                        <span class="fs-7 fw-bold text-gray-700 lh-sm" data-kt-element="desc">' . Yii::t("app", "Admin Panel") . '</span>
                                    </span>',
                                                                ['site/index'],
                                                                [
                                                                        'class' => 'btn btn-outline btn-custom btn-flex w-100',
                                                                        'encode' => false,
                                                                ]
                            );
                        ?>


                    </div>
                    <!--end::Header-->
                    <!--begin::Navs-->
                    <div class="app-sidebar-navs flex-column-fluid mx-2 py-6" id="kt_app_sidebar_navs">
                        <div id="kt_app_sidebar_navs_wrappers" class="hover-scroll-y my-2" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_header, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_navs" data-kt-scroll-offset="5px">

                            <!--begin::Sidebar menu-->
                            <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false" class="menu menu-column menu-rounded menu-sub-indention menu-active-bg">
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion <?=(Yii::$app->controller->id == 'site' ? 'here show' : '')?>">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
											<span class="menu-icon">
												<i class="ki-outline ki-home-2 fs-2"></i>
											</span>
											<span class="menu-title"><?=(Yii::t('app','Dashboard'))?></span>
											<span class="menu-arrow"></span>
										</span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion">

                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link" href="<?=(Url::to(['site/index']))?>">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                                <span class="menu-title">Default</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>

                                    </div>
                                    <!--end:Menu sub-->
                                </div>
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion <?=(Yii::$app->controller->id == 'restaurant' ? 'here show' : '')?>">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
											<span class="menu-icon">
												<i class="ki-outline ki-gift fs-2"></i>
											</span>
											<span class="menu-title"><?=(Yii::t('app','Restaurant'))?></span>
											<span class="menu-arrow"></span>
										</span>

                                    <div class="menu-sub menu-sub-accordion">

                                        <div class="menu-item">

                                            <a class="menu-link" href="<?=(Url::to(['restaurant/index']))?>">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                                <span class="menu-title">Default</span>
                                            </a>

                                        </div>

                                    </div>
                                    <!--end:Menu sub-->
                                </div>
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion <?=(Yii::$app->controller->id == 'category' ? 'here show' : '')?>">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
											<span class="menu-icon">
												<i class="ki-outline ki-abstract-26 fs-2"></i>
											</span>
											<span class="menu-title"><?=(Yii::t('app','Category'))?></span>
											<span class="menu-arrow"></span>
										</span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion">

                                        <div class="menu-item">

                                            <a class="menu-link" href="<?=(Url::to(['category/index']))?>">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                                <span class="menu-title">Default</span>
                                            </a>

                                        </div>

                                    </div>
                                    <!--end:Menu sub-->
                                </div>

                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion <?=(Yii::$app->controller->id == 'customer' ? 'here show' : '')?>">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
											<span class="menu-icon">
												<i class="ki-outline ki-abstract-26 fs-2"></i>
											</span>
											<span class="menu-title"><?=(Yii::t('app','Customer'))?></span>
											<span class="menu-arrow"></span>
										</span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion">

                                        <div class="menu-item">

                                            <a class="menu-link" href="<?=(Url::to(['customer/index']))?>">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                                <span class="menu-title">Default</span>
                                            </a>

                                        </div>

                                    </div>
                                    <!--end:Menu sub-->
                                </div>

                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion <?=(Yii::$app->controller->id == 'product' ? 'here show' : '')?>">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
											<span class="menu-icon">
												<i class="ki-outline ki-abstract-26 fs-2"></i>
											</span>
											<span class="menu-title"><?=(Yii::t('app','Product'))?></span>
											<span class="menu-arrow"></span>
										</span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion">

                                        <div class="menu-item">

                                            <a class="menu-link" href="<?=(Url::to(['product/index']))?>">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                                <span class="menu-title">Default</span>
                                            </a>

                                        </div>

                                    </div>
                                    <!--end:Menu sub-->
                                </div>
                            </div>

                            <div class="separator mx-10"></div>

                        </div>
                    </div>
                    <!--end::Navs-->
                    <!--begin::Footer-->
                    <div class="app-sidebar-footer d-flex flex-stack px-11 pb-10" id="kt_app_sidebar_footer">
                        <!--begin::User menu-->
                        <div class="">
                            <!--begin::Menu wrapper-->
                            <div class="cursor-pointer symbol symbol-circle symbol-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-overflow="true" data-kt-menu-placement="top-start">
                                <img src="<?=(Yii::getAlias('@web'))?>/image/default.jpg" alt="image" />
                            </div>
                            <!--begin::User account menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <div class="menu-content d-flex align-items-center px-3">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-50px me-5">
                                            <img alt="Logo" src="<?=(Yii::getAlias('@web'))?>/image/default.jpg"/>
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::Username-->
                                        <div class="d-flex flex-column">
                                            <div class="fw-bold d-flex align-items-center fs-5">Alice Page
                                                <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Roll</span></div>
                                            <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">alice@kt.com</a>
                                        </div>
                                        <!--end::Username-->
                                    </div>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu separator-->
                                <div class="separator my-2"></div>
                                <!--end::Menu separator-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-5">
                                    <?=(
                                     \yii\helpers\Html::a( Yii::t('app' , 'My Profile') , ['customer/index'], ['class' => 'menu-link px-5'])
                                    )?>
                                </div>

                                <div class="separator my-2"></div>
                                <!--end::Menu separator-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                                    <a href="#" class="menu-link px-5">
											<span class="menu-title position-relative"><?=(Yii::t('app','Mode'))?></span>
											<span class="ms-5 position-absolute translate-middle-y top-50 end-0">
												<i class="ki-outline ki-night-day theme-light-show fs-2"></i>
												<i class="ki-outline ki-moon theme-dark-show fs-2"></i>
											</span></span>
                                    </a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3 my-0">
                                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-outline ki-night-day fs-2"></i>
													</span>
                                                <span class="menu-title"> <?=(Yii::t('app','Light'))?></span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3 my-0">
                                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-outline ki-moon fs-2"></i>
													</span>
                                                <span class="menu-title"> <?=(Yii::t('app','Dark'))?> </span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3 my-0">
                                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-outline ki-screen fs-2"></i>
													</span>
                                                <span class="menu-title"> <?=(Yii::t('app','System'))?></span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </div>

                                <?= \common\widgets\LanguageDropdown::widget() ?>


                                <div class="menu-item px-5 my-1">
                                    <a href="account/settings.html" class="menu-link px-5">
                                        <?=(Yii::t('app','Account Settings'))?>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-5">
                                    <?=( \yii\helpers\Html::a( Yii::t('app' , Yii::t('app','Logout')) , ['site/logout'], ['class' => 'menu-link px-5']) )?>

                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::User account menu-->
                            <!--end::Menu wrapper-->
                        </div>
                        <!--end::User menu-->
                        <!--begin::Logout-->
                        <?=( Html::a(
                                '<i class="ki-outline ki-entrance-left fs-2 me-2"></i>' . Yii::t('app', 'Logout'),
                                ['site/logout'],
                                [
                                        'class' => 'btn btn-sm btn-outline btn-flex btn-custom px-3',
                                        'encode' => false,
                                ]
                        ) )?>

                        <!--end::Logout-->
                    </div>
                    <!--end::Footer-->
                </div>




                <main class="app-main flex-column flex-row-fluid p-15" id="kt_app_main">
                    <?=$content?>
                </main>

            </div>



    </div>

</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
