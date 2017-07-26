<div class="clearfix" data-bind="with:TopMenu">
    <div class="mbn-navbar clearfix" id="mbn-navbar">
        <div class="mbn-banner-appmb" data-bind="with: $parent.MBNBanner" style="background-color:#f2f2f2; width:100%">
            <div class="mbn-banner clearfix" data-bind="visible:ShowBanner()==true">
                <span class="delete" data-bind="click: CloseBanner"><i class="fa fa-remove"></i></span>
                <img data-bind="attr:{src: BannerAds}" title="" width="100%" />
                <a class="open" href="https://muaban.net/app/download">Mở</a>
            </div>
        </div>
        <div class="navbar navbar-fixed-top mbn-navbar" role="navigation" id="slide-nav">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-toggle visible-xs">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-arrow"><i class="fa fa-long-arrow-left fa-2x"></i></span>
                    </a>
                    <div class="mbn-logo">
                        <a class="logo hidden-xs" href="/">
                            <img src="https://muaban.net/Content/images/logo.gif" alt="Bao mua ban rao vat" title="Báo mua bán rao vặt" width="210" height="32" />
                        </a>

                        <a href="/" class="logo-w visible-xs">

                        <span class="float-left">
                            <img src="https://muaban.net/Content/images/logo-w.png" class="logo-w" width="140" height="24" alt="Bao mua ban rao vat" title="Báo mua bán rao vặt" />
                        </span>

                        </a>
                    </div>
                    <div class="mbn-navbar-right visible-xs">
                        <ul class="nav-right">
                            <li data-bind="with: $parent.MBNNotification">
                                <a href="/trang-ca-nhan/MyNotification" data-bind="click:  function(data,e){ data.GotoInbox('/trang-ca-nhan/MyNotification');}" class="btn-top-bell">
                                    <span class="num-message-bell" data-bind="text:TotalInboxNotReadDisplay(), style:{visibility:IsVisibleBell()==false? 'hidden':'visible'}"></span>
                                    <i class="icon icon-bell"></i>
                                </a>
                            </li>

                            <li>
                                <a data-gtm-event="mbn-event-link" data-gtm-category="mbn-search" data-gtm-action="mobile-search"
                                   href="/tim-kiem-di-dong" class="btn-top-search"><i class="fa fa-search"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--Desktop - Profile-->
                <ul class="nav navbar-nav navbar-right mbn-navbar-nav hidden-xs">
                    <li>
                        <a data-gtm-event="mbn-event-link" data-gtm-category="mbn-profile" data-gtm-action="user-signin"
                           title="Đăng nhập" href="/home/user/login/"><span>Đăng nhập</span></a>
                    </li>
                    <li class="mbn-navbar-icon-search" data-bind="style:{display: HasIconSearch()?'block':''}">
                        <a href="#" data-bind="click: ShowTopSearch"><span><i class="icon icon-search-mb"></i></span></a>
                    </li>
                    <li class="mbn-navbar-bell" data-bind="with: $parent.MBNNotification">

                        <a class="dropdown-toggle" href="javascript:void(0)" data-bind="click: function(data,e){ data.InboxMarkAsRead();}" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span><i class="icon icon-bell" data-bind="css:{'mbn-bell-blue':TotalInboxNotRead() > 0}"></i></span>
                            <span class="num-message-bell" data-bind="text: TotalInboxNotReadDisplay(), style:{visibility:IsVisibleBell()==false? 'hidden':'visible'}"></span>
                        </a>
                        <ul class="dropdown-menu mbn-dropdown-menu mbn-bell-loading" role="menu" data-bind="visible: Inboxs().length == 0 && IsLoadingBell() == true">
                            <li>Vui lòng đợi trong giây lát...</li>
                        </ul>
                        <ul class="dropdown-menu mbn-dropdown-menu mbn-bell-emty" data-bind="visible: IsLoadingBell() == false && HasInbox() == false">
                            <li data-bind="visible: Inboxs().length == 0">Không có thông báo nào</li>
                        </ul>
                        <ul class="dropdown-menu mbn-dropdown-menu mbn-bell-list" role="menu" data-bind="visible: Inboxs().length > 0">
                            <!-- ko foreach:{data: Inboxs, as: 'item'} -->
                            <li data-bind="attr:{class:item.IsRead() === false?'background-highlight':''}, click:  function(){$parent.GotoPage(item.MessageId(), item.InboxId());}">
                                <a href="javascript:void(0)">
                                    <span data-bind="html:item.Body()"></span>
                                    <div class="mbn-bell-date"><i class="icon icon-clock96"></i> <span data-bind="html:item.Created"></span></div>
                                </a>
                            </li>
                            <!-- /ko -->
                            <li class="mbn-bell-more" data-bind="visible: Inboxs().length > 0">
                                <a href="/trang-ca-nhan/MyNotification" data-bind="click:  function(data,e){ data.GotoInbox('/trang-ca-nhan/MyNotification');}">
                                    Xem thêm
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span><i class="icon icon-list-mb"></i></span>
                        </a>
                        <ul class="dropdown-menu mbn-dropdown-menu" role="menu" style="left:0px">
                            <li><a data-gtm-event="mbn-event-link" data-gtm-category="mbn-profile" data-gtm-action="menu-favorite" href="/trang-ca-nhan/MyFavorite"><i class="icon icon-common_star_favorite_bookmark_"></i> Tin yêu thích</a></li>
                            <li><a data-gtm-event="mbn-event-link" data-gtm-category="mbn-profile" data-gtm-action="menu-posting-online" href="/trang-ca-nhan#/tin-dang-web"><i class="icon icon-laptop60"></i> Tin đăng online</a></li>
                            <li><a data-gtm-event="mbn-event-link" data-gtm-category="mbn-profile" data-gtm-action="menu-posting-newspaper" href="/trang-ca-nhan#/tin-dang-bao-giay"><i class="icon icon-paper"></i> Tin đăng báo giấy</a></li>
                            <li><a data-gtm-event="mbn-event-link" data-gtm-category="mbn-profile" data-gtm-action="menu-deposit" href="/trang-ca-nhan#/nap-tien"><i class="icon icon-dollar-mb"></i> Nạp tiền</a></li>

                            <li><a data-gtm-event="mbn-event-link" data-gtm-category="mbn-profile" data-gtm-action="menu-my-info" href="/trang-ca-nhan#/thong-tin-ca-nhan" rel="nofollow"><i class="icon icon-users"></i> Thông tin cá nhân</a></li>
                            <li><a href="/trang-ca-nhan/SignUp"><i class="icon icon-sign-in"></i> Đăng ký</a></li>
                        </ul>
                    </li>
                    <li>
                        <a data-gtm-event="mbn-event-link" data-gtm-category="mbn-posting" data-gtm-action="add-posting"
                           href="/dang-tin"><span class="mbn-nav-posting text"><i class="fa fa-pencil"></i>&nbsp;ĐĂNG TIN MIỄN PHÍ</span></a>
                    </li>
                </ul>

            </div>
        </div>

        <div id="slidemenu" class="visible-sm visible-xs">
            <ul class="nav navbar-nav navbar-right">

                <li class="col-sm-12 col-xm-12 menu-home">
                    <a data-gtm-event="mbn-event-all" data-gtm-category="mbn-profile-mobile" data-gtm-action="menu-nav-home"
                       href="/">
                        <i class="fa fa-home"></i> Trang chủ
                    </a>
                </li>
                <li class="col-sm-12 col-xm-12 menu-home">
                    <a data-gtm-event="mbn-event-all" data-gtm-category="mbn-profile-mobile" data-gtm-action="menu-nav-search"
                       href="/tim-kiem-di-dong">
                        <i class="fa fa-search"></i> Tìm kiếm
                    </a>
                </li>
                <li class="col-sm-12 col-xm-12 menu-home">
                    <a data-gtm-event="mbn-event-all" data-gtm-category="mbn-posting-mobile" data-gtm-action="add-posting"
                       href="/dang-tin">
                        <i class="icon icon-laptop60"></i> Đăng tin miễn phí
                    </a>
                </li>

                <li class="col-sm-12 col-xm-12 menu-home">
                    <a data-gtm-event="mbn-event-link" data-gtm-category="mbn-profile-mobile" data-gtm-action="menu-favorite"
                       href="/trang-ca-nhan/MyFavorite">
                        <i class="icon icon-common_star_favorite_bookmark_" style="font-size:18px;"></i> Tin yêu thích
                    </a>
                </li>
                <li class="menu-line"></li>
                <li class="col-sm-12 col-xm-12">
                    <a data-gtm-event="mbn-event-link" data-gtm-category="mbn-profile-mobile" data-gtm-action="menu-signin"
                       href="/trang-ca-nhan/SignIn">Đăng nhập</a>
                </li>
                <li class="col-sm-12 col-xm-12">
                    <a data-gtm-event="mbn-event-link" data-gtm-category="mbn-profile-mobile" data-gtm-action="menu-signup"
                       href="/trang-ca-nhan/SignUp">Đăng ký</a>
                </li>
            </ul>
        </div>
        <div id="navbar-height-col"></div>
    </div>

</div>